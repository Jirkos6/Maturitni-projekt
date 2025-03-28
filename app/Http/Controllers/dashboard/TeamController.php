<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Events;
use App\Models\Achievements;
use App\Models\Attendance;
use App\Models\EventTeam;
use App\Models\MembersTeam;
use App\Models\MemberAchievement;
use App\Models\User;
use App\Models\ShirtSizes;
use App\Models\Members;
use App\Models\UserTeam;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $data = Teams::with('members')->orderBy('name', 'asc')->get();
        return view('content.dashboard.dashboards-analytics', compact('data'));
    }

    public function storeTeam(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255'
            ], [], [
                'name' => 'název družiny'
            ]);
            
            $team = new Teams;
            $team->name = $validated['name'];
            $team->save();
            
            return redirect('/')->with('success', "Družina {$team->name} byla úspěšně přidána!");
        } catch (\Exception $e) {
            return redirect('/')->with('error', "Nastala chyba při přidávání družiny: " . $e->getMessage());
        }
    }

    public function showTeam($id)
    {
        $data = Teams::findOrFail($id);
        $members = $data->members()->get();
        $eventCount = Events::join('event_team', 'events.id', '=', 'event_team.event_id')
            ->where('event_team.team_id', $id)
            ->count();

        foreach ($members as $member) {
            $presentCount = Attendance::where('member_id', $member->id)
                ->where('status', 'present')
                ->count();
            $member->attendance_percentage = $eventCount > 0
                ? round(($presentCount / $eventCount) * 100, 2)
                : 0;
        }
        $events = Events::withCount([
            'attendances as present_count' => function ($query) {
                $query->where('status', 'present');
            },
            'attendances as excused_count' => function ($query) {
                $query->where('status', 'excused');
            },
            'attendances as unexcused_count' => function ($query) {
                $query->where('status', 'unexcused');
            }
        ])
        ->whereHas('teams', function ($query) use ($id) {
            $query->where('team_id', $id);
        })
        ->orderBy('start_date', 'asc')
        ->get();
        $calendarEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => \Carbon\Carbon::parse($event->start_date)->toIso8601String(),
                'end' => \Carbon\Carbon::parse($event->end_date)->toIso8601String(),
                'description' => $event->description ?? null,
            ];
        });
        $nextEvent = Events::join('event_team', 'events.id', '=', 'event_team.event_id')
            ->where('event_team.team_id', $id)
            ->where('events.start_date', '>=', now())
            ->whereNull('events.deleted_at')
            ->select(
                'events.title',
                'events.description',
                'events.id',
                'events.start_date as start',
                'events.end_date as end'
            )
            ->orderBy('events.start_date', 'asc')
            ->first();
        $achievements = Achievements::all();
        $shirtSizes = ShirtSizes::all();
        $teams = Teams::all();
        $parents = DB::table('users')
            ->leftJoin('user_member', 'users.id', '=', 'user_member.user_id')
            ->leftJoin('members', 'user_member.member_id', '=', 'members.id')
            ->select(
                'users.id',
                'users.role',
                'users.name as parent_name',
                'users.surname as parent_surname',
                'users.email',
                DB::raw('GROUP_CONCAT(CONCAT(members.name, " ", members.surname) SEPARATOR ", ") as member_names')
            )
            ->whereNull('users.deleted_at')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.surname', 'users.role')
            ->get();

        $children = Members::whereNull('members.deleted_at')
            ->leftJoin('member_team', 'members.id', '=', 'member_team.member_id')
            ->whereNull('member_team.deleted_at')
            ->select('members.*')
            ->get();
        $memberIds = $members->pluck('id')->toArray();
        $eventIds = $events->pluck('id')->toArray();
        $attendanceData = Attendance::getStatusesForEvents($eventIds, $memberIds);
        $calendarEventsJson = $calendarEvents->toJson();

        return view('content.dashboard.dashboards-teams', [
            'data' => $data,
            'events' => $calendarEventsJson,
            'events1' => $events,
            'eventsCollection' => $events->sortBy('start_date'),
            'members' => $members,
            'memberCount' => $members->count(),
            'nextEvent' => $nextEvent,
            'attendance' => $events,
            'achievements' => $achievements,
            'shirt_sizes' => $shirtSizes,
            'teams' => $teams,
            'parents' => $parents,
            'children' => $children,
            'attendanceData' => $attendanceData,
            'id1' => $id,
            'presence' => $events,
        ]);
    }
    public function deleteTeam($id)
    {
        try {
            $team = Teams::findOrFail($id);
            $eventIds = EventTeam::where('team_id', $id)->pluck('event_id');
            Events::whereIn('id', $eventIds)->delete();
            EventTeam::where('team_id', $id)->delete();
            $memberIds = MembersTeam::where('team_id', $id)->pluck('member_id');
            Members::whereIn('id', $memberIds)->delete();
            MembersTeam::where('team_id', $id)->delete();
            $team->delete();
            return redirect('/')->with('success', 'Družina úspěšně smazána.');
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Nastala chyba při mazání družiny.');
        }
    }
}
