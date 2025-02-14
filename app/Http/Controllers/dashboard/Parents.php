<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Members;
use App\Models\Teams;
use App\Models\Attendance;
use App\Models\MembersTeam;


class Parents extends Controller
{
  public function index(Request $request)
  {
    $id = auth()->user()->id;
    $data = Members::leftJoin('member_team', 'members.id', '=', 'member_team.member_id')
    ->leftJoin('teams', 'member_team.team_id', '=', 'teams.id')
    ->where('members.user_id', $id)
    ->select('teams.name as teams_name', 'teams.id as teams_id', 'members.*')
    ->get();

    return view('content.dashboard.dashboards-parents', compact('data'));
  }
  public function settings()
  {
    return view('content.dashboard.dashboards-parents-settings');
  }
  public function members($id)
  {
    $userid = auth()->user()->id;
    $members = Members::findOrFail($id)->first();
    if ($members && $members->user_id == $userid)
    {
      $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
      ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
      ->where('members.id', $id)->select('achievements.*')->orderBy('id','desc')->get();
      $attendance = Attendance::where('member_id',$id)->get();
      $attendancesum = $attendance->whereIn('status', ['excused', 'unexcused'])->count();
      if ($attendancesum > 0) {
          $attendancepercentage = round($attendance->where('status', 'present')->count() / $attendancesum * 100);
      } else {
          $attendancepercentage = 0;
      }
      $attendances = Attendance::join('events', 'attendance.event_id', '=', 'events.id')
      ->where('attendance.member_id', $members->id)
      ->where('events.start_date', '>=', \Carbon\Carbon::now())
      ->whereNull('attendance.confirmed_by_parent')
      ->orderBy('events.start_date', 'ASC')
      ->select('attendance.*')
      ->with('event')
      ->get();
      $teamid = MembersTeam::where('member_id',$id)->pluck('team_id');
      $teamname = Teams::find($teamid)->first();
      $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $teamid)->select(
        'events.title',
        'events.description',
        'events.id',
        'events.start_date as start',
        'events.end_date as end')->orderBy('start','asc')->get();
        $upcomingeventcount = 0;
        if ($upcomingevents->first()) {
          foreach ($upcomingevents as $e) {
        if (!\Carbon\Carbon::parse($e->start)->isPast()) {
          $upcomingeventcount++;
        }
      }
      }

    return view('content.dashboard.dashboards-parents-members', compact('members','achievements','attendancepercentage','upcomingeventcount','teamname','upcomingevents','attendances'));
    }
    else {
      return redirect()->back();
    }
  }
  public function attendance ($id) {
    $userid = auth()->user()->id;
    $members = Members::findOrFail($id)->first();
    if ($members && $members->user_id == $userid)
    {
      $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
      ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
      ->where('members.id', $id)->select('achievements.*')->orderBy('id','desc')->get();
      $attendance = Attendance::where('member_id',$id)->get();
      $attendancesum = $attendance->whereIn('status', ['excused', 'unexcused'])->count();
      if ($attendancesum > 0) {
          $attendancepercentage = round($attendance->where('status', 'present')->count() / $attendancesum * 100);
      } else {
          $attendancepercentage = 0;
      }
      $teamid = MembersTeam::where('member_id',$id)->pluck('team_id');
      $teamname = Teams::find($teamid)->first();
      $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $teamid)->select(
        'events.title',
        'events.description',
        'events.id',
        'events.start_date as start',
        'events.end_date as end')->orderBy('start','asc')->get();
        $upcomingeventcount = 0;
        if ($upcomingevents->first()) {
          foreach ($upcomingevents as $e) {
        if (!\Carbon\Carbon::parse($e->start)->isPast()) {
          $upcomingeventcount++;
        }
      }
      }
      $attendances = Attendance::join('events', 'attendance.event_id', '=', 'events.id')
      ->where('attendance.member_id', $members->id)
      ->where('events.start_date', '>=', \Carbon\Carbon::now())
      ->whereNull('attendance.confirmed_by_parent')
      ->orderBy('events.start_date', 'ASC')
      ->select('attendance.*')
      ->with('event')
      ->get();

      return view('content.dashboard.dashboards-parents-attendance', compact('achievements','attendancepercentage','upcomingeventcount','members','attendances'));
    }
    else {
      return redirect()->back();
    }
  }
  public function achievements ($id) {
    $userid = auth()->user()->id;
    $members = Members::findOrFail($id)->first();
    if ($members && $members->user_id == $userid)
    {
      $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
      ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
      ->where('members.id', $id)->select('achievements.*')->orderBy('id','desc')->get();
      $attendance = Attendance::where('member_id',$id)->get();
      $attendancesum = $attendance->whereIn('status', ['excused', 'unexcused'])->count();
      if ($attendancesum > 0) {
          $attendancepercentage = round($attendance->where('status', 'present')->count() / $attendancesum * 100);
      } else {
          $attendancepercentage = 0;
      }
      $teamid = MembersTeam::where('member_id',$id)->pluck('team_id');
      $teamname = Teams::find($teamid)->first();
      $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $teamid)->select(
        'events.title',
        'events.description',
        'events.id',
        'events.start_date as start',
        'events.end_date as end')->orderBy('start','asc')->get();
        $upcomingeventcount = 0;
        if ($upcomingevents->first()) {
          foreach ($upcomingevents as $e) {
        if (!\Carbon\Carbon::parse($e->start)->isPast()) {
          $upcomingeventcount++;
        }
      }
      }

      return view('content.dashboard.dashboards-parents-achievements', compact('achievements','attendancepercentage','upcomingeventcount','members'));
    }
    else {
      return redirect()->back();
    }
  }
  public function calendar ($id) {
    $userid = auth()->user()->id;
    $members = Members::findOrFail($id)->first();
    if ($members && $members->user_id == $userid)
    {
      $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
      ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
      ->where('members.id', $id)->select('achievements.*')->orderBy('id','desc')->get();
      $attendance = Attendance::where('member_id',$id)->get();
      $attendancesum = $attendance->whereIn('status', ['excused', 'unexcused'])->count();
      if ($attendancesum > 0) {
          $attendancepercentage = round($attendance->where('status', 'present')->count() / $attendancesum * 100);
      } else {
          $attendancepercentage = 0;
      }
      $teamid = MembersTeam::where('member_id',$id)->pluck('team_id');
      $teamname = Teams::find($teamid)->first();
      $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')->where('teams.id', $teamid)->select(
        'events.title',
        'events.description',
        'events.id',
        'events.start_date as start',
        'events.end_date as end')->orderBy('start','asc')->get();
        $upcomingeventcount = 0;
        if ($upcomingevents->first()) {
          foreach ($upcomingevents as $e) {
        if (!\Carbon\Carbon::parse($e->start)->isPast()) {
          $upcomingeventcount++;
        }
      }
      }
      $events = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
      ->join('events', 'events.id', '=', 'event_team.event_id')
      ->leftJoin('recurring_events', 'events.id', '=', 'recurring_events.event_id')
      ->where('teams.id', $teamid)
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
$events = $transformedEvents->toJson();

      return view('content.dashboard.dashboards-parents-calendar', compact('achievements','attendancepercentage','upcomingeventcount','members','events','teamname'));
    }
    else {
      return redirect()->back();
    }
  }
  public function attendanceconfirm($id, Request $request)
{
    $attendance = Attendance::findOrFail($id);

    if ($attendance->confirmed_by_parent) {
      $request->session()->flash('success', "Úspěšně potvrzeno!");
      return redirect()->back();
    }

    $attendance->confirmed_by_parent = 1;
    $attendance->save();

    $request->session()->flash('success', "Úspěšně potvrzeno!");
    return redirect()->back();
}
}
