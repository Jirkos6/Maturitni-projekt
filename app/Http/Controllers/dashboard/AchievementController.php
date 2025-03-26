<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievements;
use App\Models\MembersAchievement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AchievementController extends Controller
{
    public function storeAchievement(Request $request)
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Nastala chyba při přidávání!" . $e->getMessage())->withFragment('#navs-pills-top-achievements');
        }
    }

    public function updateAchievement(Request $request, $id)
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Nastala chyba při editaci!" . $e->getMessage())->withFragment('#navs-pills-top-achievements');
        }
    }

    public function deleteAchievement($id)
    {
        $achievement = Achievements::findOrFail($id);
        if ($achievement) {
            $achievementMembers = MembersAchievement::where('achievement_id', $id)->get();
            foreach ($achievementMembers as $a)
            {
              error_log($a->id);
              $a->delete();
            }
            File::delete(asset('storage/achievements/' . $achievement->image));
            $achievement->delete();
            return redirect()->back()->with('success', 'Položka byla úspěšně smazána!');
        } else {
            return redirect()->back()->with('error', 'Položka neexistuje!');
        }
    }

    public function assignMemberAchievements(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'achievement_id' => 'required|array',
            'achievement_id.*' => 'exists:achievements,id',
        ]);

        MembersAchievement::where('member_id', $validated['member_id'])->delete();
        foreach ($validated['achievement_id'] as $achievementId) {
            MembersAchievement::create([
                'member_id' => $validated['member_id'],
                'achievement_id' => $achievementId,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Odborky úspěšně přidány!']);
    }
    public function showAchievements()
    {
      $data = Achievements::All();
      return view('content.dashboard.dashboards-achievements',compact('data'));
    }


    public function getMemberAchievements($id)
    {
        $achievements = MembersAchievement::where('member_id', $id)
            ->pluck('achievement_id')
            ->toArray();

        return response()->json($achievements);
    }
}
