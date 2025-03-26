<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\TeamController;
use App\Http\Controllers\dashboard\MemberController;
use App\Http\Controllers\dashboard\EventController;
use App\Http\Controllers\dashboard\AchievementController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\AttendanceController;
use App\Http\Controllers\dashboard\ParentDashboardController;
use App\Http\Controllers\dashboard\ShirtSizeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\pages\AccountSettingsAccount;

Route::middleware([
    'auth:sanctum',
    'user_has_admin',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('dashboard-analytics');
    Route::post('/teams', [TeamController::class, 'storeTeam']);
    Route::get('/teams/{id}', [TeamController::class, 'showTeam'])->name('dashboard-teams');
    Route::post('/events', [EventController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}', [EventController::class, 'showEvent'])->name('dashboard-events');
    Route::delete('/event/{id}', [EventController::class, 'deleteEvent'])->name('events.delete');
    Route::get('/members/{member_id}', [MemberController::class, 'showMember'])->name('member.team.show');
    Route::post('/members', [MemberController::class, 'storeMember'])->name('member.store');
    Route::post('/members-multiple', [MemberController::class, 'storeMultipleMembers'])->name('member.store.multiple');
    Route::put('/member-edit/{id}', [MemberController::class, 'updateMember'])->name('member.update');
    Route::delete('/member/{id}', [MemberController::class, 'deleteMember']);
    Route::post('/achievement', [AchievementController::class, 'storeAchievement'])->name('achievements.store');
    Route::put('/achievement/{id}', [AchievementController::class, 'updateAchievement'])->name('achievements.update');
    Route::delete('/achievement/{id}', [AchievementController::class, 'deleteAchievement']);
    Route::post('/member-achievements', [AchievementController::class, 'assignMemberAchievements'])->name('member-achievements.store');
    Route::get('/member-achievements/{id}', [AchievementController::class, 'getMemberAchievements'])->name('member-achievements.get');
    Route::post('/users', [UserController::class, 'storeUser'])->name('user.store');
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
    Route::get('/user/{id}', [UserController::class, 'showUser'])->name('users.show');
    Route::post('/user-members', [UserController::class, 'assignMembersToUser'])->name('user-members.store');
    Route::get('/user-members/{id}', [UserController::class, 'getUserMembers'])->name('user-members.get');
    Route::post('/users-role/{id}', [UserController::class, 'updateUserRole'])->name('users.role');
    Route::post('/update-attendance', [AttendanceController::class, 'updateAttendance'])->name('attendance.update');
    Route::get('/account/settings', [AccountSettingsAccount::class, 'index'])->name('dashboard-settings');
    Route::get('/achievements', [AchievementController::class, 'showAchievements'])->name('achievements.show');
    Route::get('/shirt-sizes', [ShirtSizeController::class, 'showShirtSizes'])->name('shirt-sizes.show');
    Route::delete('/shirt-sizes/{id}', [ShirtSizeController::class, 'deleteShirtSize'])->name('shirt-sizes.delete');
    Route::delete('/team/{id}', [TeamController::class, 'deleteTeam'])->name('team.delete');
    Route::post('/shirt-sizes', [ShirtSizeController::class, 'storeShirtSize'])->name('shirt-sizes.store');
    Route::get('/global-events', [EventController::class, 'showGlobalEvents'])->name('global-events.show');
    Route::post('/events/update-multiple', [EventController::class, 'updateMultipleEvents'])->name('events.update.multiple');
    Route::delete('/events/delete-multiple', [EventController::class, 'deleteMultipleEvents'])->name('events.delete.multiple');
    Route::put('/events/{id}', [EventController::class, 'updateEvent'])->name('events.update');
    Route::get('/messages', function() {
        return view('content.dashboard.dashboards-messages');
    })->name('messages.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [ParentDashboardController::class, 'showSettings'])->name('dashboard.settings');


    Route::middleware(['user_has_member'])->group(function () {
        Route::get('/dashboard/members/{id}', [ParentDashboardController::class, 'showMemberDetails'])->name('dashboard.members');
        Route::get('/dashboard/members/achievements/{id}', [ParentDashboardController::class, 'showMemberAchievements'])->name('dashboard.achievements');
        Route::get('/dashboard/members/calendar/{id}', [ParentDashboardController::class, 'showMemberCalendar'])->name('dashboard.calendar');
        Route::get('/dashboard/members/attendance/{id}', [ParentDashboardController::class, 'showMemberAttendance'])->name('dashboard.attendance');
        Route::post('/dashboard/members/attendance/confirm/{id}/{attendanceid}', [ParentDashboardController::class, 'confirmAttendance'])->name('attendance.confirm');
    });
});
Route::fallback(function() {
    return view('errors.404');
});
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google.redirect');

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    if ($googleUser) {
        $user = User::where('email', $googleUser->email)?->first();
        if ($user) {
            $user->update([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);
            return redirect('/dashboard');
        } else {
            return redirect('/login')->with('error', 'Nebyl vám vytvořen účet administrátorem!');
        }
    } else {
        return redirect('/login')->with('error', 'Nastala chyba při přihlašování. Zkuste to znovu později.');
    }
})->name('google.callback');
Route::get('/login/{email}/{password}', [UserController::class, 'autoLogin'])->name('auto.login');
