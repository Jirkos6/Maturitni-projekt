<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserHasAdminRole;
use App\Http\Middleware\EnsureUserHasMember;
return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
   $middleware->alias([
    'user_has_admin' => EnsureUserHasAdminRole::class,
    'user_has_member' => EnsureUserHasMember::class,
]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
