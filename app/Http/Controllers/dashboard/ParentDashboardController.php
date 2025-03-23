<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Members;
use App\Models\Teams;
use App\Models\Attendance;
use App\Models\MembersTeam;
use App\Models\UserMember;
class ParentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $data = Members::leftJoin('member_team', 'members.id', '=', 'member_team.member_id')
            ->leftJoin('teams', 'member_team.team_id', '=', 'teams.id')
            ->leftJoin('user_member','members.id','=','user_member.member_id')
            ->where('user_member.user_id', $id)
            ->select('teams.name as teams_name', 'teams.id as teams_id', 'members.*')
            ->whereNull('members.deleted_at')
            ->whereNull('user_member.deleted_at')
            ->whereNull('member_team.deleted_at')
            ->get();

        return view('content.dashboard.dashboards-parents', compact('data'));
    }

    public function showSettings()
    {
        return view('content.dashboard.dashboards-parents-settings');
    }

    public function showMemberDetails($id)
    {
        $members = Members::findOrFail($id);
            $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
                ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
                ->where('members.id', $id)->select('achievements.*')->orderBy('id', 'desc')->get();
            $attendance = Attendance::where('member_id', $id)->get();
            $attendancesum = $attendance->count();
            $attendancepercentage = $attendancesum > 0
                ? round($attendance->where('status', 'present')->count() / $attendancesum * 100)
                : 0;
            $attendances = Attendance::join('events', 'attendance.event_id', '=', 'events.id')
                ->where('attendance.member_id', $members->id)
                ->where('events.start_date', '>=', \Carbon\Carbon::now())
                ->whereNull('attendance.confirmed_by_parent')
                ->orderBy('events.start_date', 'ASC')
                ->select('attendance.*')
                ->with('event')
                ->get();
            $teamid = MembersTeam::where('member_id', $id)->pluck('team_id');
            $teamname = Teams::find($teamid)->first();
            $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
                ->join('events', 'events.id', '=', 'event_team.event_id')
                ->whereNull('teams.deleted_at')
                ->whereNull('event_team.deleted_at')
                ->whereNull('events.deleted_at')
                ->where('teams.id', $teamid)
                ->select(
                    'events.title',
                    'events.description',
                    'events.id',
                    'events.start_date as start',
                    'events.end_date as end'
                )
                ->orderBy('start', 'asc')
                ->get();
            $upcomingeventcount = 0;
            if ($upcomingevents->first()) {
                foreach ($upcomingevents as $e) {
                    if (!\Carbon\Carbon::parse($e->start)->isPast()) {
                        $upcomingeventcount++;
                    }
                }
            }

            return view('content.dashboard.dashboards-parents-members', compact('members', 'achievements', 'attendancepercentage', 'upcomingeventcount', 'teamname', 'upcomingevents', 'attendances'));
    }

    public function showMemberAttendance($id)
    {
        $members = Members::findOrFail($id);
            $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
                ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
                ->where('members.id', $id)->select('achievements.*')->orderBy('id', 'desc')->get();
            $attendance = Attendance::where('member_id', $id)->get();
            $attendancesum = $attendance->count();
            $attendancepercentage = $attendancesum > 0
                ? round($attendance->where('status', 'present')->count() / $attendancesum * 100)
                : 0;
            $teamid = MembersTeam::where('member_id', $id)->pluck('team_id');
            $teamname = Teams::find($teamid)->first();
            $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
                ->join('events', 'events.id', '=', 'event_team.event_id')
                ->where('teams.id', $teamid)
                ->whereNull('teams.deleted_at')
                ->whereNull('event_team.deleted_at')
                ->whereNull('events.deleted_at')
                ->select(
                    'events.title',
                    'events.description',
                    'events.id',
                    'events.start_date as start',
                    'events.end_date as end'
                )
                ->orderBy('start', 'asc')
                ->get();
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

            return view('content.dashboard.dashboards-parents-attendance', compact('achievements', 'attendancepercentage', 'upcomingeventcount', 'members', 'attendances', 'teamname'));
    }

    public function showMemberAchievements($id)
    {
        $members = Members::findOrFail($id);
            $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
                ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
                ->where('members.id', $id)->select('achievements.*')->orderBy('id', 'desc')->paginate(10);
            $attendance = Attendance::where('member_id', $id)->get();
            $attendancesum = $attendance->count();
            $attendancepercentage = $attendancesum > 0
                ? round($attendance->where('status', 'present')->count() / $attendancesum * 100)
                : 0;
            $teamid = MembersTeam::where('member_id', $id)->pluck('team_id');
            $teamname = Teams::find($teamid)->first();
            $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
                ->join('events', 'events.id', '=', 'event_team.event_id')
                ->where('teams.id', $teamid)
                ->whereNull('teams.deleted_at')
                ->whereNull('event_team.deleted_at')
                ->whereNull('events.deleted_at')
                ->select(
                    'events.title',
                    'events.description',
                    'events.id',
                    'events.start_date as start',
                    'events.end_date as end'
                )
                ->orderBy('start', 'asc')
                ->get();
            $upcomingeventcount = 0;
            if ($upcomingevents->first()) {
                foreach ($upcomingevents as $e) {
                    if (!\Carbon\Carbon::parse($e->start)->isPast()) {
                        $upcomingeventcount++;
                    }
                }
            }

            return view('content.dashboard.dashboards-parents-achievements', compact('achievements', 'attendancepercentage', 'upcomingeventcount', 'members', 'teamname'));

    }

    public function showMemberCalendar($id)
    {
        $members = Members::findOrFail($id);
            $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
                ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
                ->where('members.id', $id)
                ->whereNull('members.deleted_at')
                ->whereNull('member_achievement.deleted_at')
                ->whereNull('achievements.deleted_at')
                ->select('achievements.*')
                ->orderBy('id', 'desc')
                ->get();
            $attendance = Attendance::where('member_id', $id)
                ->whereNull('deleted_at')
                ->get();
            $attendancesum = $attendance->count();
            $attendancepercentage = $attendancesum > 0
                ? round($attendance->where('status', 'present')->count() / $attendancesum * 100)
                : 0;
            $teamid = MembersTeam::where('member_id', $id)
                ->whereNull('deleted_at')
                ->pluck('team_id');
            $teamname = Teams::whereNull('deleted_at')
                ->find($teamid)
                ->first();
            $upcomingevents = Teams::join('event_team', 'teams.id', '=', 'event_team.team_id')
                ->join('events', 'events.id', '=', 'event_team.event_id')
                ->where('teams.id', $teamid)
                ->whereNull('teams.deleted_at')
                ->whereNull('event_team.deleted_at')
                ->whereNull('events.deleted_at')
                ->select(
                    'events.title',
                    'events.description',
                    'events.id',
                    'events.start_date as start',
                    'events.end_date as end'
                )
                ->orderBy('start', 'asc')
                ->get();
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
                ->where('teams.id', $teamid)
                ->whereNull('teams.deleted_at')
                ->whereNull('event_team.deleted_at')
                ->whereNull('events.deleted_at')
                ->select(
                    'events.title',
                    'events.description',
                    'events.id',
                    'events.start_date as start',
                    'events.end_date as end'
                )
                ->get();

            $transformedEvents = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => \Carbon\Carbon::parse($event->start)->toIso8601String(),
                    'end' => \Carbon\Carbon::parse($event->end)->toIso8601String(),
                    'description' => $event->description ?? null,
                ];
            });
            $events = $transformedEvents->toJson();

            return view('content.dashboard.dashboards-parents-calendar', compact('achievements', 'attendancepercentage', 'upcomingeventcount', 'members', 'events', 'teamname'));

    }

    public function confirmAttendance($id, $attendanceid, Request $request)
    {
        $attendance = Attendance::findOrFail($attendanceid);
        $member = Members::findOrFail($id);
        if ($attendance->confirmed_by_parent) {
                return response()->json([
                    'success' => true,
                    'attendance_id' => $attendance->id,
                    'message' => 'Účast na této akci už byla potvrzena!'
                ]);
        }

        $attendance->update(['confirmed_by_parent' => 1]);

            return response()->json([
                'success' => true,
                'attendance_id' => $attendance->id,
                'message' => 'Úspěšně potvrzeno!'
           ]);

    }

}
