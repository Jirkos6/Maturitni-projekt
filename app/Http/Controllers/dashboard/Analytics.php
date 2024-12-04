<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Events;
use App\Models\Members;
use App\Models\EventTeam;
use App\Models\Achievements;
use App\Models\RecurringEvents;
use App\Models\ShirtSizes;
use App\Models\Attendance;
use Illuminate\Support\Str;
class Analytics extends Controller
{
  private function convertDayOfWeek($dayOfWeek)
{
    $days = ['su', 'mo', 'tu', 'we', 'th', 'fr', 'sa'];
    return array_map(function ($day) use ($days) {
        return $days[$day - 1]; 
    }, explode(',', $dayOfWeek));
}
  public function index(Request $request)
  {
 
    $data = Teams::with('members')->orderBy('name','asc')->get(); 
    return view('content.dashboard.dashboards-analytics', ['data' => $data]);
  }
  public function store(Request $request)
  {
      try {
          $request->validate([
              'name' => 'required|string|max:255'
          ]);
          $team = new Teams;
          $team->name = $request->input('name');
          $team->save(); 
          $request->session()->flash('success', "Tým $team->name byl úspěšně přidán!");
          return redirect('/');
      } catch (\Exception $e) {
          $request->session()->flash('error', "Nastala chyba při přidávání týmu! " . $e->getMessage());
          return redirect('/');
      }
  }
  public function memstore(Request $request)
  {
      try {
        $validated = $request->validate([
          'name' => 'required|string|max:255',
          'surname' => 'required|string|max:255',
          'age' => 'nullable|integer', 
          'shirt_size_id' => 'nullable|exists:shirt_sizes,id',
          'nickname' => 'nullable|string|max:255',
          'telephone' => 'nullable|string|max:255',
          'email' => 'nullable|email|max:255',
          'mother_name' => 'nullable|string|max:255',
          'mother_surname' => 'nullable|string|max:255',
          'mother_telephone' => 'nullable|string|max:255',
          'mother_email' => 'nullable|email|max:255',
          'father_name' => 'nullable|string|max:255',
          'father_surname' => 'nullable|string|max:255',
          'father_telephone' => 'nullable|string|max:255',
          'father_email' => 'nullable|email|max:255',
          'team_id' => 'required|exists:teams,id',
        ]);
          $member = new Members;
          $member->name = $validated['name'];
          $member->surname = $validated['surname'];
          $member->age = $validated['age'];
          $member->shirt_size_id = $validated['shirt_size_id'];
          $member->nickname = $validated['nickname'];
          $member->telephone = $validated['telephone'];
          $member->email = $validated['email'];
          $member->mother_name = $validated['mother_name'];
          $member->mother_surname = $validated['mother_surname'];
          $member->mother_telephone = $validated['mother_telephone'];
          $member->mother_email = $validated['mother_email'];
          $member->father_name = $validated['father_name'];
          $member->father_surname = $validated['father_surname'];
          $member->father_telephone = $validated['father_telephone'];
          $member->father_email = $validated['father_email'];
          $member->save(); 
          $team_id = $validated['team_id'];
          $member->teams()->attach($team_id);
          $request->session()->flash('success', "Člen $member->name byl úspěšně přidán!");
          return redirect()->back()->withFragment('#navs-pills-top-messages');
      } catch (\Exception $e) {
          $request->session()->flash('error', "Nastala chyba při přidávání člena! " . $e->getMessage());
          return redirect()->back()->withFragment('#navs-pills-top-messages');
      }
  }
  public function teams($id)
  {

      $data = Teams::where('id', $id)->get(); 
      $id1 = $id;
      $attendance = Events::withCount([
        'attendances as present_count' => function ($query) {
            $query->where('status', 'present');
        },
        'attendances as excused_count' => function ($query) {
            $query->where('status', 'excused');
        },
        'attendances as unexcused_count' => function ($query) {
            $query->where('status', 'unexcused');
        }
    ])->get();
 
      $members = Teams::with('members')->where('id', $id)->get()->pluck('members')->flatten();
      $events = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')
      ->leftJoin('recurring_events', 'events.id', '=', 'recurring_events.event_id')
      ->where('teams.id', $id)
      ->select(
          'events.title',
          'events.description',
          'events.id',
          'events.start_date as start',
          'events.end_date as end',
          'events.is_recurring as recurring',
          'recurring_events.frequency',
          'recurring_events.day_of_week',
          'recurring_events.day_of_month',
          'recurring_events.end_date as recurring_end',
          'recurring_events.repeat_count',
          'recurring_events.interval'
      )
      ->get();
      $achievements = Achievements::all();
      $presence = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $id)->orderBy('start_date','asc')->get();

      $nextevent = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $id)->select(
        'events.title',
        'events.description',
        'events.id',
        'events.start_date as start',
        'events.end_date as end')->orderBy('events.start_date','desc')->first();
        if ($nextevent) {
        if (\Carbon\Carbon::parse($nextevent->start)->isPast()) {
        $nextevent = null;
        }
      
        }
          $transformedEvents = $events->map(function ($event) {
            if ($event->recurring == 1) {
                $rrule = [
                    'freq' => $event->frequency,
                    
                ];
                if ($event->repeat_count) {
                  $rrule['count'] = $event->repeat_count;
                }
                if ($event->reccuring_end) {
                  $rrule['until'] = \Carbon\Carbon::parse($event->recurring_end)->toIso8601String();
                }
                if ($event->day_of_week) {
                  $rrule['byweekday'] = $this->convertDayOfWeek($event->day_of_week);
                }
        
                if ($event->day_of_month) {
                    $rrule['bymonthday'] = $event->day_of_month;
                }

        
                $event->rrule = $rrule;
            }
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => \Carbon\Carbon::parse($event->start)->toIso8601String(), 
                'end' => \Carbon\Carbon::parse($event->end)->toIso8601String(),
                'rrule' => $event->rrule ?? null, 
                'description' => $event->description ?? null, 
            ];
        });
      $memberCount = Teams::find($id)->members()->count();
      $events = $transformedEvents->toJson();
      $shirt_sizes = ShirtSizes::all();
      return view('content.dashboard.dashboards-teams', compact('events', 'data','nextevent','memberCount','members','presence','achievements','id1','shirt_sizes','attendance'));
  }

  public function achdelete($id) {
    $achievement = Achievements::findOrFail($id);
    if ($achievement) {
    $achievement->delete();
    return redirect()->back()->with('success', 'Položka byla úspěšně smazána!');   
    }
    else {
    return redirect()->back()->with('error', 'Položka neexistuje!');   
    }
  }
    public function memdelete($id) {
      $member = Members::findOrFail($id);
      if ($member) {
      $member->delete();
      return redirect()->back()->with('success', 'Položka byla úspěšně smazána!')->withFragment('#navs-pills-top-messages'); 
      }
      else {
      return redirect()->back()->with('error', 'Položka neexistuje!')->withFragment('#navs-pills-top-messages');
      }

  }
  public function members($member_id) {
    $data = Members::join('shirt_sizes', 'members.shirt_size_id', '=', 'shirt_sizes.id')->leftJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')  
    ->leftJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id') 
    ->where('members.id', $member_id)->select('members.*','shirt_sizes.*','members.id as members_id')
    ->first();
    $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')  
    ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id') 
    ->where('members.id', $member_id)->select('achievements.*')->get();
    $shirt_sizes = ShirtSizes::all();
    return view('content.dashboard.dashboards-members', compact('data','achievements','shirt_sizes'));
  }

public function memupdate(Request $request, $id)
{
  try {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'surname' => 'required|string|max:255',
      'age' => 'nullable|integer', 
      'shirt_size_id' => 'nullable|exists:shirt_sizes,id',
      'nickname' => 'nullable|string|max:255',
      'telephone' => 'nullable|string|max:255',
      'email' => 'nullable|email|max:255',
      'mother_name' => 'nullable|string|max:255',
      'mother_surname' => 'nullable|string|max:255',
      'mother_telephone' => 'nullable|string|max:255',
      'mother_email' => 'nullable|email|max:255',
      'father_name' => 'nullable|string|max:255',
      'father_surname' => 'nullable|string|max:255',
      'father_telephone' => 'nullable|string|max:255',
      'father_email' => 'nullable|email|max:255',
      'created_at' => 'nullable|date',
      'updated_at' => 'nullable|date',
      'deleted_at' => 'nullable|date',
    ]);
    $member = Members::findOrFail($id);
    $member->update($validated);
    return redirect()->back()->with('success', 'Člen byl úspěšně upraven!')->withFragment('#navs-pills-top-messages');
  } catch (\Exception $e) {
    return redirect()->back()->with('error', "Nastala chyba při editaci!" . $e->getMessage())->withFragment('#navs-pills-top-messages');
  }
  }


  public function achupdate(Request $request, $id)
  {
    try {
      $validated = $request->validate([
          'name' => 'required|string|max:255',
          'description' => 'nullable|string',
          'image' => 'nullable|image|max:2048',
      ]);

      $achievement = Achievements::findOrFail($id);
      $achievement->name = $validated['name'];
      $achievement->description = $validated['description'];
      if ($request->hasFile('image')) {
          $imageName = Str::random(40) . '.' . $request->file('image')->getClientOriginalExtension();
          $imagePath = $request->file('image')->storeAs('achievements', $imageName, 'public');
          $achievement->image = $imageName;
      }

      $achievement->save();

      return redirect()->back()->with('success', 'Odborka byla úspěšně upravena!')->withFragment('#navs-pills-top-achievements');
    }
    catch(\Exception $e) {
      return redirect()->back()->with('error', "Nastala chyba při editaci!" . $e->getMessage())->withFragment('#navs-pills-top-achievements');
    }
  }
  public function achstore(Request $request)
  {
    try {
      $validated = $request->validate([
          'name' => 'required|string|max:255',
          'description' => 'nullable|string',
          'image' => 'nullable|image|max:2048',
      ]);

      $achievement = new Achievements();
      $achievement->name = $validated['name'];
      $achievement->description = $validated['description'];

      if ($request->hasFile('image')) {
          $imageName = Str::random(40) . '.' . $request->file('image')->getClientOriginalExtension();
          $imagePath = $request->file('image')->storeAs('achievements', $imageName, 'public');
          $achievement->image = $imageName;
      }

      $achievement->save();
      return redirect()->back()->with('success', "Přidání proběhlo úspěšně!")->withFragment('#navs-pills-top-achievements');
    }
      catch(\Exception $e) {
        return redirect()->back()->with('error', "Nastala chyba při přidávání!" . $e->getMessage())->withFragment('#navs-pills-top-achievements');
      }
}

public function eventstore(Request $request)
{
    try {
        if ($request->has('daily') || $request->has('weekly')) {
            $request->merge(['is_recurring' => 1]);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'recurrence.frequency' => 'required_if:is_recurring,1|in:daily,weekly',
            'recurrence.day_of_week' => 'nullable|string',
            'recurrence.day_of_month' => 'nullable|string',
            'recurrence.end_date' => 'nullable|date|after:start_date',
            'recurrence.interval' => 'nullable|integer',
            'recurrence.repeat_count' => 'nullable|integer|min:1',
            'team_id' => 'required|exists:teams,id',
        ]);

        if ($request->input('recurrence.repeat_count') && $request->input('recurrence.end_date')) {
            throw new \Exception('Událost nemůže mít počet opakování a konec opakování zároveň.');
        }
        $event = new Events();
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->start_date = $request->input('start_datetime');
        $event->end_date = $request->input('end_datetime');
        $event->is_recurring = $request->input('is_recurring');
        $event->save();
        if ($request->input('is_recurring')) {
            $recurringEvent = new RecurringEvents();
            $recurringEvent->event_id = $event->id;
            $recurringEvent->frequency = $request->input('recurrence.frequency');
            $recurringEvent->day_of_week = $request->input('recurrence.day_of_week');
            $recurringEvent->day_of_month = $request->input('recurrence.day_of_month');
            $recurringEvent->end_date = $request->input('recurrence.end_date');
            $recurringEvent->interval = $request->input('recurrence.interval');
            $recurringEvent->repeat_count = $request->input('recurrence.repeat_count');
            $recurringEvent->save();
        }
        $team = Teams::findOrFail($request->input('team_id'));
        $team->events()->attach($event);
        $members = $team->members; 
        foreach ($members as $member) {
            Attendance::create([
                'event_id' => $event->id,
                'member_id' => $member->id,
                'status' => 'unexcused',  
                'confirmed_by_parent' => null, 
            ]);
        }
        $request->session()->flash('success', "Událost '{$event->title}' byla úspěšně přidána a přiřazena k týmu!");

        return redirect()->back();
    } catch (\Exception $e) {
        $request->session()->flash('error', "Nastala chyba při přidávání události! " . $e->getMessage());
        return redirect()->back();
    }
  
}
public function eventview($id) {
$data = Events::find($id);
return view ('content.dashboard.dashboards-events',compact('data'));
}

}