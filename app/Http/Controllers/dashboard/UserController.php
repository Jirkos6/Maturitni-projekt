<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMember;
use App\Models\Members;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
            $user = new User;
            $user->name = $validated['name'];
            $user->surname = $validated['surname'];
            $user->email = $validated['email'];
            $password = Str::random(8);
            $hash = Hash::make($password);
            $user->password = $hash;
            $user->save();
            if ($request->input('emailCheckbox') == true) {
                Mail::to($user->email)->send(new AccountCreated($user->name, $user->surname, $password, $user->email));
                $request->session()->flash('success', "Uživatel $user->name $user->surname byl úspěšně přidán a email zaslán! Heslo uživatele je: $password");
            } else {
                $request->session()->flash('success', "Uživatel $user->name $user->surname byl úspěšně přidán! Heslo je: $password");
            }
            return redirect()->back()->withFragment('#navs-pills-top-parents');
        } catch (\Exception $e) {
            $request->session()->flash('error', "Nastala chyba při přidávání rodiče! " . $e->getMessage());
            return redirect()->back()->withFragment('#navs-pills-top-parents');
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $members = Members::where('user_id', $id);
            if($user->role === 'admin' && User::where('role','admin')->count() === 1)
            {
            return redirect()->back()->with('error', 'Nemůžete smazat svůj administrátorský účet když je poslední!')->withFragment('#navs-pills-top-parents');
            }
            else {
              $user->delete();
              return redirect()->back()->with('success', 'Položka byla úspěšně smazána!')->withFragment('#navs-pills-top-parents');
            }
        } else {
            return redirect()->back()->with('error', 'Položka neexistuje!')->withFragment('#navs-pills-top-parents');
        }
    }


    public function assignMembersToUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'member_id' => 'required|array',
            'member_id.*' => 'exists:members,id',
        ]);

        UserMember::where('user_id', $validated['user_id'])->delete();

        foreach ($validated['member_id'] as $memberId) {
            UserMember::create([
                'user_id' => $validated['user_id'],
                'member_id' => $memberId,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Členové úspěšně přiřazeni!']);
    }

    public function updateUserRole($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);
            $adminCount = User::where('role', 'admin')->count();
            if ($user->role == 'admin' && $adminCount == 1 && $request->user()->id == $user->id) {
                $request->session()->flash('error', "Nemůžeš si změnit roli, když jsi poslední administrátor!");
                return redirect()->back()->withFragment('#navs-pills-top-parents');
            }
            $newRole = $user->role === 'parent' ? 'admin' : 'parent';
            $user->update(['role' => $newRole]);

            $request->session()->flash('success', "Role byla úspěšně nastavena!");
            return redirect()->back()->withFragment('#navs-pills-top-parents');

        } catch (\Exception $e) {
            $request->session()->flash('error', "Nastala chyba při změně role! " . $e->getMessage());
            return redirect()->back()->withFragment('#navs-pills-top-parents');
        }
    }


    public function showUser($id)
    {
        $user = DB::table('users')
            ->leftJoin('user_member', 'users.id', '=', 'user_member.user_id')
            ->leftJoin('members', 'user_member.member_id', '=', 'members.id')
            ->select(
                'users.id',
                'users.role',
                'users.name as parent_name',
                'users.surname as parent_surname',
                'users.email',
                'users.created_at',
                DB::raw('GROUP_CONCAT(CONCAT(members.name, " ", members.surname) SEPARATOR ", ") as member_names')
            )
            ->where('users.id', $id)
            ->groupBy('users.id', 'users.role', 'users.name', 'users.surname', 'users.email', 'users.created_at')
            ->first();
        $children = DB::table('members')
            ->whereNotExists(function ($query) use ($id) {
                $query->select(DB::raw(1))
                    ->from('user_member')
                    ->whereRaw('members.id = user_member.member_id')
                    ->where('user_member.user_id', $id);
            })
            ->select('id', 'name', 'surname')
            ->get();

        return view('content.dashboard.dashboards-users', compact('user', 'children'));
    }
    public function autoLogin($email, $password)
    {
      $this->email = $email;
      $this->password = $password;
      try
      {
        $user = User::where('email',$email)->first();
        if (!$user)
        {
          return redirect('/login');
        }
        if (Hash::check($password, $user->password))
        {
          Auth::login($user);
          return redirect('/');
        }
        return redirect('/login');


      }
      catch (Exception $e)
      {
        return redirect('/login');

      }
    }

    /**
     * Get all members assigned to a user
     */
    public function getUserMembers($id)
    {
        $members = UserMember::where('user_id', $id)
            ->pluck('member_id')
            ->toArray();

        return response()->json($members);
    }
}
