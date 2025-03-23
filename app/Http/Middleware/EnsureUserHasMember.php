<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserMember;

class EnsureUserHasMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $memberId = $request->route('id');
        $userId = $request->user()?->id;
        if (!$userId || !$memberId) {
            return redirect('/dashboard');
        }
        $hasAssociation = UserMember::where('member_id', $memberId)
            ->where('user_id', $userId)
            ->exists();
        if ($hasAssociation) {
            return $next($request);
        }
        return redirect('/dashboard');
    }
}
