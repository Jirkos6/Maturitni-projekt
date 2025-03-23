<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\EventTeam;
use App\Models\Teams;
use App\Models\Attendance;
use App\Mail\EventEmail;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{

    public function showEvent($id)
    {
        $data = Events::find($id);
        return view('content.dashboard.dashboards-events', compact('data'));
    }

    public function deleteEvent($id)
    {
      $event = Events::findOrFail($id);
      if($event) {
        $eventAttendences = Attendance::where('event_id',$event->id)->get();
        $eventTeams = EventTeam::where('event_id',$event->id)->get();
        foreach($eventAttendences as $e)
        {
          $e->delete();
        }
        foreach($eventTeams as $t)
        {
          $t->delete();
        }
        $event->delete();

        return redirect()->back()->with('success', 'Položka byla úspěšně smazána!')->withFragment('#navs-pills-events');
      }
      else {
        return redirect()->back()->with('error', 'Položka neexistuje!')->withFragment('#navs-pills-top-parents');
      }
    }

    public function showGlobalEvents()
    {
        $ids = Events::has('teams', '>=', 2)
            ->pluck('id')
            ->all();
        $data = Events::whereIn('id', $ids)
            ->with(['teams' => function ($query) {
                $query->select('teams.id', 'teams.name');
            }])
            ->get();

        $teams = Teams::all();

        return view('content.dashboard.dashboards-global-events', compact('data', 'teams'));
    }

    public function storeEvent(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_datetime' => 'required|date_format:Y-m-d H:i',
                'end_datetime' => 'required|date_format:Y-m-d H:i|after_or_equal:start_datetime',
                'team_id' => 'nullable|exists:teams,id',
                'team_ids' => 'nullable|array|min:2',
                'team_ids.*' => 'exists:teams,id',
                'recurrence' => 'nullable|in:daily,weekly,monthly',
                'recurrenceInterval' => 'nullable|integer|min:1',
                'recurrenceEndDate' => 'nullable|date_format:Y-m-d|after:start_datetime',
                'recurrenceRepeatCount' => 'nullable|integer|min:1|max:50',
                'filterOutHolidayDates' => 'nullable',
                'sendMailCheckbox' => 'nullable',
            ]);


            if (!isset($validated['team_id']) && !isset($validated['team_ids'])) {
                throw new \Exception('Musíte vybrat alespoň jednu družinu (team_id) nebo více družin (team_ids).');
            }

            if (isset($validated['team_id']) && isset($validated['team_ids'])) {
                throw new \Exception('Nelze zadat team_id a team_ids současně.');
            }

            $teamIds = $validated['team_ids'] ?? [$validated['team_id']];
            $teams = Teams::whereIn('id', $teamIds)->with('members')->get();

            if ($teams->isEmpty()) {
                throw new \Exception('Vybrané družiny neexistují.');
            }

            if (isset($validated['team_ids']) && $teams->count() < 2) {
                throw new \Exception('Pro více družin musíte vybrat alespoň 2 družiny.');
            }

            $sendMail = $validated['sendMailCheckbox'] ?? null;
            $recurrenceType = $validated['recurrence'] ?? null;
            $interval = (int) ($validated['recurrenceInterval'] ?? 1);
            $endDate = $validated['recurrenceEndDate'] ?? null;
            $repeatCount = (int) ($validated['recurrenceRepeatCount'] ?? 0);
            $filterOutHolidays = isset($validated['filterOutHolidayDates']) && $validated['filterOutHolidayDates'] === 'on';

            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_datetime']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_datetime']);
            $duration = $startDateTime->diffInSeconds($endDateTime);
            $emailCount = 0;
            $recurringEndDate = $endDate ? Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay() : null;
            $estimatedEventCount = 1;

            if ($recurrenceType) {
                if ($repeatCount > 0) {
                    $estimatedEventCount = $repeatCount;
                } else if ($recurringEndDate) {
                    $diffInDays = $startDateTime->diffInDays($recurringEndDate);

                    switch ($recurrenceType) {
                        case 'daily':
                            $estimatedEventCount = ceil($diffInDays / $interval) + 1;
                            break;
                        case 'weekly':
                            $estimatedEventCount = ceil($diffInDays / (7 * $interval)) + 1;
                            break;
                        case 'monthly':
                            $estimatedEventCount = ceil($startDateTime->diffInMonths($recurringEndDate) / $interval) + 1;
                            break;
                    }
                }
            }

            if ($estimatedEventCount > 50) {
                throw new \Exception('Počet opakovaných akcí nesmí překročit 50. Odhadovaný počet: ' . $estimatedEventCount);
            }

            $eventDates = $this->generateRecurringDates(
                $startDateTime,
                $recurrenceType,
                $interval,
                $recurringEndDate,
                $repeatCount,
                $filterOutHolidays
            );

            if (empty($eventDates)) {
                throw new \Exception('Nepodařilo se vygenerovat žádné datum události. Všechny termíny kolidují se svátky.');
            }

            if (count($eventDates) > 50) {
                throw new \Exception('Počet opakovaných akcí nesmí překročit 50. Aktuální počet: ' . count($eventDates));
            }

            $uniqueMembers = $teams->pluck('members')->flatten()->unique('id');

            $createdEvents = [];

            foreach ($eventDates as $eventDate) {
                $event = new Events();
                $event->title = $validated['title'];
                $event->description = $validated['description'] ?? null;
                $event->start_date = $eventDate;
                $event->end_date = $eventDate->copy()->addSeconds($duration);
                $event->save();
                $createdEvents[] = $event->id;

                $event->teams()->attach($teamIds);

                foreach ($teams as $team) {
                    $members = $team->members;
                    foreach ($members as $member) {
                        Attendance::create([
                            'event_id' => $event->id,
                            'member_id' => $member->id,
                            'status' => 'present',
                            'confirmed_by_parent' => null,
                        ]);
                    }
                }
            }
            if ($sendMail && !empty($createdEvents)) {
                $firstEvent = Events::find($createdEvents[0]);
                foreach ($uniqueMembers as $member) {
                    if ($member->mother_email) {
                        Mail::to($member->mother_email)->send(new EventEmail(
                            $firstEvent->title,
                            $firstEvent->description,
                            $firstEvent->start_date,
                            $firstEvent->end_date
                        ));
                        $emailCount++;
                    }

                    if ($member->father_email) {
                        Mail::to($member->father_email)->send(new EventEmail(
                            $firstEvent->title,
                            $firstEvent->description,
                            $firstEvent->start_date,
                            $firstEvent->end_date
                        ));
                        $emailCount++;
                    }
                }
            }


            $request->session()->flash('success', "" . $sendMail ? "Událost '{$validated['title']}' byla úspěšně přidána! (Vytvořeno " . count($createdEvents) . " událostí). Bylo zasláno {$emailCount} mailů!" : "Událost '{$validated['title']}' byla úspěšně přidána! (Vytvořeno " . count($createdEvents) . " událostí)");
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', "Nastala chyba při přidávání události! " . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    private function generateRecurringDates($startDate, $recurrenceType, $interval, $endDate, $repeatCount, $filterOutHolidays)
    {
        if (!$recurrenceType || (!$repeatCount && !$endDate)) {
            return [$startDate->copy()];
        }

        $dates = [];
        $currentDate = $startDate->copy();
        $count = 0;
        $maxOccurrences = $repeatCount ? min(50, $repeatCount) : 50;

        while ($count < $maxOccurrences && (!$endDate || $currentDate <= $endDate)) {
            $dates[] = $currentDate->copy();
            $count++;

            if ($count >= $maxOccurrences) {
                break;
            }

            switch ($recurrenceType) {
                case 'daily':
                    $currentDate = $startDate->copy()->addDays($interval * $count);
                    break;
                case 'weekly':
                    $currentDate = $startDate->copy()->addWeeks($interval * $count);
                    break;
                case 'monthly':
                    $currentDate = $startDate->copy()->addMonths($interval * $count);
                    break;
                default:
                    break 2;
            }

            if ($endDate && $currentDate > $endDate) {
                break;
            }
        }


        if (!$filterOutHolidays) {
            return $dates;
        }

        try {
            $startDateStr = $startDate->format('Y-m-d');
            $lastDate = end($dates) ?: $startDate;
            $daysDifference = $startDate->diffInDays($lastDate);

            if ($daysDifference <= 0) {
                return $dates;
            }

            $response = Http::timeout(10)->get("https://svatkyapi.cz/api/day/{$startDateStr}/interval/{$daysDifference}");

            if ($response->failed()) {
                return $dates;
            }

            $holidayData = $response->json();

            $holidays = collect($holidayData)
                ->filter(function($day) {
                    return $day['isHoliday'] === true;
                })
                ->pluck('date')
                ->toArray();


            if (empty($holidays)) {
                return $dates;
            }

            $filteredDates = array_values(array_filter($dates, function ($date) use ($holidays) {
                return !in_array($date->format('Y-m-d'), $holidays);
            }));

            if (empty($filteredDates) && !empty($dates)) {
                return [$startDate->copy()];
            }

            return $filteredDates;
        } catch (\Exception $e) {
            return $dates;
        }
    }
    public function updateMultipleEvents(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date_format:Y-m-d',
                'end_date' => 'nullable|date_format:Y-m-d',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after_or_equal:start_datetime',
                'team_id' => 'nullable',
                'team_ids' => 'nullable|array',
                'team_ids.*' => 'nullable|exists:teams,id',
                'event_ids' => 'required|array',
                'event_ids.*' => 'exists:events,id'
            ]);

            $title = $validated['title'] ?? null;
            $description = $validated['description'] ?? null;
            $start_date = isset($validated['start_date']) ? ($validated['start_date'] . ' ' . ($validated['start_time'] ?? '16:00') . ':00') : null;
            $end_date = isset($validated['end_date']) ? ($validated['end_date'] . ' ' . ($validated['end_time'] ?? '18:00') . ':00') : null;
            $teamIds = $validated['team_ids'] ?? null;
            $eventIds = $validated['event_ids'];
            $iteration = 0;

            if ($title || $description || $start_date || $end_date || $teamIds !== null) {
                foreach ($eventIds as $eventId) {
                    $event = Events::find($eventId);

                    if ($title) {
                        $event->update(['title' => $title]);
                    }
                    if ($description) {
                        $event->update(['description' => $description]);
                    }
                    if ($start_date) {
                        $event->update(['start_date' => $start_date]);
                    }
                    if ($end_date) {
                        $event->update(['end_date' => $end_date]);
                    }
                    if ($teamIds !== null) {
                        $currentTeamIds = $event->teams->pluck('id')->all();
                        if (empty(array_filter($teamIds))) {
                            EventTeam::where('event_id', $eventId)->forceDelete();
                            Attendance::where('event_id', $eventId)->forceDelete();
                        } else {
                            EventTeam::where('event_id', $eventId)->forceDelete();
                            Attendance::where('event_id', $eventId)->forceDelete();
                            foreach (array_filter($teamIds) as $teamId) {
                                EventTeam::create([
                                    'event_id' => $eventId,
                                    'team_id' => $teamId
                                ]);

                                $team = Teams::find($teamId);
                                foreach ($team->members as $member) {
                                    Attendance::create([
                                        'event_id' => $eventId,
                                        'member_id' => $member->id,
                                        'status' => 'present',
                                        'confirmed_by_parent' => 0
                                    ]);
                                }
                            }
                        }
                    }
                    $iteration++;
                }
                return redirect()->back()->with('success', 'Akce úspěšně upraveny! Počet: ' . $iteration);
            } else {
                return redirect()->back()->with('error', 'Nejsou žadná data pro editaci!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Nastala chyba při editaci: ' . $e->getMessage());
        }
    }
    public function deleteMultipleEvents(Request $request)
    {
      error_log($request);
      try {
      $validated = $request->validate([
      'event_ids' => 'required|array',
      'event_ids.*' => 'exists:events,id'
    ]);
    $eventIds = $validated['event_ids'];
    $i = 0;
    if ($eventIds)
    {
      foreach ($eventIds as $ids)
      {
        Events::find($ids)->forceDelete();
        EventTeam::where('event_id',$ids)->forceDelete();
        Attendance::where('event_id',$ids)->forceDelete();
        $i++;
      }
      return redirect()->back()->with('success', 'Bylo úspěšně smazáno ' . $i . ' položek');
    }
    else {
      return redirect()->back()->with('error', 'Nejsou definované položky');
    }
  } catch(Exception $e)
  {
    return redirect()->back()->with('error', 'Nastala chyba při mazání položek: '. $e);
  }

    }


    public function updateEvent(Request $request, $id)
    {
      try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
        ]);
        $startDatetime = Carbon::parse("{$validated['start_date']} {$validated['start_time']}");
        $endDatetime = Carbon::parse("{$validated['end_date']} {$validated['end_time']}");
        if ($endDatetime->lessThanOrEqualTo($startDatetime)) {
            return redirect()->back()->with('error','Konec akce musí být po začátku akce.')->withInput()->withFragment('#navs-pills-events');
        }
        $event = Events::findOrFail($id);
        $event->updateOrFail([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $startDatetime,
            'end_date' => $endDatetime,
        ]);
        return redirect()->back()->with('success', 'Akce byla úspěšně aktualizována.')->withFragment('#navs-pills-events');
      } catch (Exception $e)
      {
        return redirect()->back()->with('error', 'Nastala chyba při editaci ' . $e)->withFragment('#navs-pills-events');
      }
    }
}
