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
        $members = $teams->pluck('members')->flatten()->unique('id');
        $attendanceData = [];
        foreach ($data as $event) {
            $attendanceData[$event->id] = Attendance::where('event_id', $event->id)
                ->with('member')
                ->get()
                ->groupBy('member_id');
        }

        return view('content.dashboard.dashboards-global-events', compact('data', 'teams', 'members', 'attendanceData'));
    }

    public function storeEvent(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'start_datetime' => 'required|date_format:Y-m-d H:i',
                'end_datetime' => 'required|date_format:Y-m-d H:i|after_or_equal:start_datetime',
                'team_id' => 'nullable|exists:teams,id',
                'team_ids' => 'nullable|array|min:2',
                'team_ids.*' => 'exists:teams,id',
                'recurrence' => 'nullable|in:daily,weekly,monthly',
                'recurrenceInterval' => 'nullable|integer|min:1',
                'recurrenceEndDate' => 'nullable|date_format:Y-m-d|after:start_datetime',
                'recurrenceRepeatCount' => 'nullable|integer|min:1|max:50',
                'sendMailCheckbox' => 'nullable',
            ], [], [
                'title' => 'název akce',
                'description' => 'popis',
                'start_datetime' => 'začátek akce',
                'end_datetime' => 'konec akce',
                'team_id' => 'družina',
                'team_ids' => 'družiny',
                'team_ids.*' => 'vybraná družina',
                'recurrence' => 'opakování',
                'recurrenceInterval' => 'interval opakování',
                'recurrenceEndDate' => 'datum konce opakování',
                'recurrenceRepeatCount' => 'počet opakování',
                'sendMailCheckbox' => 'odeslat email'
            ]);

            if (!isset($validated['team_id']) && !isset($validated['team_ids'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Musíte vybrat alespoň jednu družinu.');
            }
            $teamIds = $validated['team_ids'] ?? [$validated['team_id']];
            $teams = Teams::whereIn('id', $teamIds)->with('members')->get();

            if ($teams->isEmpty()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Vybrané družiny neexistují.');
            }

            if (isset($validated['team_ids']) && $teams->count() < 2) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pro více družin musíte vybrat alespoň 2 družiny.');
            }
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_datetime']);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_datetime']);
            $duration = $startDateTime->diffInSeconds($endDateTime);
            $eventDates = $this->calculateEventDates(
                $startDateTime,
                $validated['recurrence'] ?? null,
                (int) ($validated['recurrenceInterval'] ?? 1),
                $validated['recurrenceEndDate'] ?? null,
                (int) ($validated['recurrenceRepeatCount'] ?? 0)
            );
            if (count($eventDates) > 50) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Počet opakovaných akcí nesmí překročit 50. Aktuální počet: ' . count($eventDates));
            }
            $createdEvents = [];
            $uniqueMembers = $teams->pluck('members')->flatten()->unique('id');

            foreach ($eventDates as $eventDate) {
                $event = Events::create([
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'start_date' => $eventDate,
                    'end_date' => $eventDate->copy()->addSeconds($duration)
                ]);

                $createdEvents[] = $event->id;
                $event->teams()->attach($teamIds);
                $attendanceRecords = [];
                foreach ($uniqueMembers as $member) {
                    $attendanceRecords[] = [
                        'event_id' => $event->id,
                        'member_id' => $member->id,
                        'status' => 'present',
                        'confirmed_by_parent' => null
                    ];
                }
                Attendance::insert($attendanceRecords);
            }
            $emailCount = 0;
            if (!empty($createdEvents) && ($validated['sendMailCheckbox'] ?? false)) {
                $emailCount = $this->sendEventEmails($uniqueMembers, Events::find($createdEvents[0]));
            }
            $successMessage = "Událost '{$validated['title']}' byla úspěšně přidána! (Vytvořeno " . count($createdEvents) . " událostí)";
            if ($emailCount > 0) {
                $successMessage .= " Bylo zasláno {$emailCount} mailů!";
            }

            return redirect()->back()->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    private function calculateEventDates($startDateTime, $recurrenceType, $interval, $endDate, $repeatCount)
    {
        if (!$recurrenceType || !($repeatCount > 0 || $endDate)) {
            return [$startDateTime];
        }

        $recurringEndDate = $endDate ? Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay() : null;
        $dates = [$startDateTime];
        $currentDate = $startDateTime->copy();

        while (count($dates) < $repeatCount || ($recurringEndDate && $currentDate->lt($recurringEndDate))) {
            switch ($recurrenceType) {
                case 'daily':
                    $currentDate = $currentDate->addDays($interval);
                    break;
                case 'weekly':
                    $currentDate = $currentDate->addWeeks($interval);
                    break;
                case 'monthly':
                    $currentDate = $currentDate->addMonths($interval);
                    break;
            }

            if ($recurringEndDate && $currentDate->gt($recurringEndDate)) {
                break;
            }

            if ($repeatCount && count($dates) >= $repeatCount) {
                break;
            }

            $dates[] = $currentDate->copy();
        }

        return $dates;
    }
    private function sendEventEmails($members, $event)
    {
        $emailCount = 0;
        foreach ($members as $member) {
            if ($member->mother_email) {
                try {
                    Mail::to($member->mother_email)->send(new EventEmail(
                        $event->title,
                        $event->description,
                        $event->start_date,
                        $event->end_date
                    ));
                    $emailCount++;
                } catch (\Exception $e) {
                    continue;
                }
            }

            if ($member->father_email) {
                try {
                    Mail::to($member->father_email)->send(new EventEmail(
                        $event->title,
                        $event->description,
                        $event->start_date,
                        $event->end_date
                    ));
                    $emailCount++;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        return $emailCount;
    }

    public function updateMultipleEvents(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'start_date' => 'nullable|date_format:Y-m-d',
                'end_date' => 'nullable|date_format:Y-m-d',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after_or_equal:start_datetime',
                'team_id' => 'nullable',
                'team_ids' => 'nullable|array',
                'team_ids.*' => 'nullable|exists:teams,id',
                'event_ids' => 'required|array',
                'event_ids.*' => 'exists:events,id'
            ], [], [
                'title' => 'název akce',
                'description' => 'popis',
                'start_date' => 'datum začátku',
                'end_date' => 'datum konce',
                'start_time' => 'čas začátku',
                'end_time' => 'čas konce',
                'team_id' => 'družina',
                'team_ids' => 'družiny',
                'team_ids.*' => 'vybraná družina',
                'event_ids' => 'vybrané akce',
                'event_ids.*' => 'vybraná akce'
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
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    public function deleteMultipleEvents(Request $request)
    {
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
                'description' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'required|date_format:H:i',
            ], [], [
                'title' => 'název akce',
                'description' => 'popis',
                'start_date' => 'datum začátku',
                'end_date' => 'datum konce',
                'start_time' => 'čas začátku',
                'end_time' => 'čas konce'
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
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage())
                ->withFragment('#navs-pills-events');
        }
    }
}
