<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Members;
use App\Models\Teams;
use App\Models\Events;
use App\Models\EventTeam;
use App\Models\Attendance;
use App\Models\ShirtSizes;
use App\Models\Achievements;

class MemberController extends Controller
{
    public function storeMember(Request $request)
    {
        try {
            error_log($request);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'nullable|string|max:255',
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
            $member->age = $validated['age'] ?? null;
            $member->shirt_size_id = $validated['shirt_size_id'] ?? null;
            $member->nickname = $validated['nickname'] ?? null;
            $member->telephone = $validated['telephone'] ?? null;
            $member->email = $validated['email'] ?? null;
            $member->mother_name = $validated['mother_name'] ?? null;
            $member->mother_surname = $validated['mother_surname'] ?? null;
            $member->mother_telephone = $validated['mother_telephone'] ?? null;
            $member->mother_email = $validated['mother_email'] ?? null;
            $member->father_name = $validated['father_name'] ?? null;
            $member->father_surname = $validated['father_surname'] ?? null;
            $member->father_telephone = $validated['father_telephone'] ?? null;
            $member->father_email = $validated['father_email'] ?? null;
            $member->save();
            $team_id = $validated['team_id'];
            $member->teams()->attach($team_id);
            $eventids = EventTeam::where('team_id', $team_id)->pluck('event_id');
            $events = Events::whereIn('id', $eventids)->get();
            foreach ($events as $item) {
                Attendance::create([
                    'event_id' => $item->id,
                    'member_id' => $member->id,
                    'status' => 'present',
                    'confirmed_by_parent' => null,
                ]);
            }
            $request->session()->flash('success', "Člen $member->name $member->surname $member->nickname byl úspěšně přidán!");
            return redirect()->back()->withFragment('#navs-pills-top-messages');
        } catch (\Exception $e) {
            $request->session()->flash('error', "Nastala chyba při přidávání člena! " . $e->getMessage());
            return redirect()->back()->withFragment('#navs-pills-top-messages');
        }
    }

    public function storeMultipleMembers(Request $request)
    {
        try {
            $validated = $request->validate([
                'members.*.name' => 'required|string|max:255',
                'members.*.surname' => 'required|string|max:255',
                'members.*.age' => 'nullable|integer',
                'members.*.shirt_size_id' => 'nullable|exists:shirt_sizes,id',
                'members.*.nickname' => 'nullable|string|max:255',
                'members.*.telephone' => 'nullable|string|max:255',
                'members.*.email' => 'nullable|email|max:255',
                'members.*.mother_name' => 'nullable|string|max:255',
                'members.*.mother_surname' => 'nullable|string|max:255',
                'members.*.mother_telephone' => 'nullable|string|max:255',
                'members.*.mother_email' => 'nullable|email|max:255',
                'members.*.father_name' => 'nullable|string|max:255',
                'members.*.father_surname' => 'nullable|string|max:255',
                'members.*.father_telephone' => 'nullable|string|max:255',
                'members.*.father_email' => 'nullable|email|max:255',
                'team_id' => 'required|exists:teams,id',
            ]);
            foreach ($validated['members'] as $memberData) {
                $member = new Members;
                $member->name = $memberData['name'];
                $member->surname = $memberData['surname'];
                $member->age = $memberData['age'];
                $member->shirt_size_id = $memberData['shirt_size_id'];
                $member->nickname = $memberData['nickname'];
                $member->telephone = $memberData['telephone'];
                $member->email = $memberData['email'];
                $member->mother_name = $memberData['mother_name'];
                $member->mother_surname = $memberData['mother_surname'];
                $member->mother_telephone = $memberData['mother_telephone'];
                $member->mother_email = $memberData['mother_email'];
                $member->father_name = $memberData['father_name'];
                $member->father_surname = $memberData['father_surname'];
                $member->father_telephone = $memberData['father_telephone'];
                $member->father_email = $memberData['father_email'];
                $member->save();
                $team_id = $validated['team_id'];
                $eventids = EventTeam::where('team_id', $team_id)->pluck('event_id');
                $events = Events::whereIn('id', $eventids)->get();
                $member->teams()->attach($team_id);
                foreach ($events as $item) {
                    Attendance::create([
                        'event_id' => $item->id,
                        'member_id' => $member->id,
                        'status' => 'present',
                        'confirmed_by_parent' => null,
                    ]);
                }
            }
            $request->session()->flash('success', "Členové byli úspěšně přidáni!");
            return redirect()->back()->withFragment('#navs-pills-top-messages');
        } catch (\Exception $e) {
            $request->session()->flash('error', "Nastala chyba při přidávání členů! " . $e->getMessage());
            return redirect()->back()->withFragment('#navs-pills-top-messages');
        }
    }

    public function showMember($member_id)
    {
        $data = Members::where('members.id', $member_id)
            ->leftJoin('shirt_sizes', 'members.shirt_size_id', '=', 'shirt_sizes.id')
            ->leftJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
            ->whereNull('members.deleted_at')
            ->whereNull('shirt_sizes.deleted_at')
            ->whereNull('member_achievement.deleted_at')
            ->select('members.*', 'shirt_sizes.*', 'members.id as members_id')
            ->first();

        $achievements = Members::rightJoin('member_achievement', 'members.id', '=', 'member_achievement.member_id')
            ->rightJoin('achievements', 'member_achievement.achievement_id', '=', 'achievements.id')
            ->where('members.id', $member_id)
            ->whereNull('members.deleted_at')
            ->whereNull('member_achievement.deleted_at')
            ->whereNull('achievements.deleted_at')
            ->select('achievements.*')
            ->get();

        $shirt_sizes = ShirtSizes::all();
        return view('content.dashboard.dashboards-members', compact('data', 'achievements', 'shirt_sizes'));
    }

    public function updateMember(Request $request, $id)
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
            ]);
            $member = Members::findOrFail($id);
            $member->update($validated);
            return redirect()->back()->with('success', 'Člen byl úspěšně upraven!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Nastala chyba při editaci!" . $e->getMessage());
        }
    }

    public function deleteMember($id)
    {
        $member = Members::findOrFail($id);
        if ($member) {
            $member->delete();
            $attendance = Attendance::where('member_id', $id);
            $attendance->delete();
            return redirect('/')->with('success', 'Položka byla úspěšně smazána!');
        } else {
            return redirect()->back()->with('error', 'Položka neexistuje!')->withFragment('#navs-pills-top-messages');
        }
    }
}
