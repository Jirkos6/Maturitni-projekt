<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showUserDetails($id)
    {
        // Find user by ID with relation to his children through user_member table
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

        // Get all available children for assignment
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
}
