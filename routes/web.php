<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Parents;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;


Route::middleware([
    'auth:sanctum','sudouser',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/events/{id}', [Analytics::class, 'eventview'])->name('dashboard-events');
    Route::get('/account/settings', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/teams/{id}', [Analytics::class, 'teams'])->name('dashboard-teams');
    Route::delete('/achievement/{id}', [Analytics::class, 'achdelete']);
    Route::post('/teams', [Analytics::class, 'store']);
    Route::get('/members/{member_id}', [Analytics::class, 'members'])->name('member.team.show');
    Route::delete('/member/{id}', [Analytics::class, 'memdelete']);
    Route::put('/member-edit/{id}', [Analytics::class, 'memupdate'])->name('member.update');
    Route::post('/members', [Analytics::class, 'memstore'])->name('member.store');
    Route::post('/members-multiple', [Analytics::class, 'memstoremultiple'])->name('member.store.multiple');
    Route::put('/achievement/{id}', [Analytics::class, 'achupdate'])->name('achievements.update');
    Route::post('/achievement', [Analytics::class, 'achstore'])->name('achievements.store');
    Route::post('/events', [Analytics::class, 'eventstore'])->name('events.store');
    Route::post('/member-achievements', [Analytics::class, 'memachstore'])->name('member-achievements.store');
    Route::post('/update-attendance', [Analytics::class, 'attendanceupdate'])->name('attendance.update');
    Route::post('/users', [Analytics::class, 'userstore'])->name('user.store');
    Route::delete('/user/{id}', [Analytics::class, 'userdelete']);
    Route::post('/user-members', [Analytics::class, 'assignmembers'])->name('user-members.store');
    Route::get('/parents/{id}', [Analytics::class, 'users'])->name('users.show');
    Route::post('/users-role/{id}', [Analytics::class, 'usersrole'])->name('users.role');
    Route::get('/events/{id}', [Analytics::class, 'events'])->name('events.show');

});
Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified'
])->group(function () {
Route::get('/dashboard', [Parents::class, 'index'])->name('dashboard');
Route::get('/settings', [Parents::class, 'settings'])->name('dashboard.settings');
Route::get('/dashboard/members/{id}', [Parents::class, 'members'])->name('dashboard.members');
Route::get('/dashboard/members/achievements/{id}', [Parents::class, 'achievements'])->name('dashboard.achievements');
Route::get('/dashboard/members/calendar/{id}', [Parents::class, 'calendar'])->name('dashboard.calendar');
Route::get('/dashboard/members/attendance/{id}', [Parents::class, 'attendance'])->name('dashboard.attendance');
Route::post('/dashboard/members/attendance/confirm/{id}', [Parents::class, 'attendanceconfirm'])->name('attendance.confirm');
});
Route::fallback(function(){
  return view('errors.404');
});
