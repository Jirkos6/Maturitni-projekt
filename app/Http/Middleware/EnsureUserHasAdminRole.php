<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not authenticated or doesn't have the 'admin' role
        if (!$request->user() || !$request->user()->hasRole('admin')) {
            return redirect('/dashboard'); // Redirect to dashboard if not an admin
        }

        return $next($request); // Proceed to the next middleware/route
    }
}
