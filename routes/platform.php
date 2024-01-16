<?php

declare(strict_types=1);


use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\SchoolClass\SchoolEditScreen;
use App\Orchid\Screens\SchoolClass\SchoolListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));




Route::screen('school', SchoolListScreen::class)
    ->name('platform.schools.school.list');
Route::screen('school/{schoolClass}/edit', SchoolEditScreen::class)
    ->name('platform.schools.school.edit');
Route::screen('school/create', SchoolEditScreen::class)
    ->name('platform.schools.school.create');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
use App\Orchid\Screens\Student\StudentEditScreen;
use App\Orchid\Screens\Student\StudentListScreen;
use App\Orchid\Screens\Student\StudentShowScreen;
use App\Orchid\Screens\Student\StudentQrcodeScreen;

Route::screen('students', StudentListScreen::class)
    ->name('platform.students.list');
Route::screen('student/{student}/edit', StudentEditScreen::class)
    ->name('platform.students.edit');
Route::screen('student/create', StudentEditScreen::class)
    ->name('platform.students.create');
Route::screen('student/{student}/show', StudentShowScreen::class)
    ->name('platform.students.show');
Route::screen('student/{student}/qrcode', StudentQrcodeScreen::class)
    ->name('platform.students.qrcode');

use App\Orchid\Screens\Score\ScoreEditScreen;
use App\Orchid\Screens\Score\ScoreListScreen;

Route::screen('scores', ScoreListScreen::class)
    ->name('platform.scores.list');
Route::screen('score/{score}/edit', ScoreEditScreen::class)
    ->name('platform.scores.edit');
Route::screen('score/create', ScoreEditScreen::class)
    ->name('platform.scores.create');

// routes/web.php



use App\Orchid\Screens\ContactBook\ContactBookListScreen;
use App\Orchid\Screens\ContactBook\ContactBookEditScreen;

Route::screen('contact-book', ContactBookListScreen::class)
    ->name('platform.contactbook.list');
Route::screen('contact-book/{contact-book}/edit', ContactBookEditScreen::class)
    ->name('platform.contactbook.edit');
Route::screen('contact-book/create', ContactBookEditScreen::class)
    ->name('platform.contactbook.create');

use App\Orchid\Screens\StudentNotification\StudentNotificationListScreen;
use App\Orchid\Screens\StudentNotification\StudentNotificationEditScreen;

Route::screen('student-notification', StudentNotificationListScreen::class)
    ->name('platform.student-notification.list');
Route::screen('student-notification/{student-notification}/edit', StudentNotificationEditScreen::class)
    ->name('platform.student-notification.edit');
Route::screen('student-notification/create', StudentNotificationEditScreen::class)
    ->name('platform.student-notification.create');

use App\Orchid\Screens\ClassNotification\ClassNotificationListScreen;
use App\Orchid\Screens\ClassNotification\ClassNotificationEditScreen;

Route::screen('class-notification', ClassNotificationListScreen::class)
    ->name('platform.class-notification.list');
Route::screen('class-notification/{class-notification}/edit', ClassNotificationEditScreen::class)
    ->name('platform.class-notification.edit');
Route::screen('class-notification/create', ClassNotificationEditScreen::class)
    ->name('platform.class-notification.create');
