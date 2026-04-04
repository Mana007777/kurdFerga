<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'landing-page')->name('home');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::livewire('activity', 'pages::activity')->name('activity');
    });

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');

    // Admin Course Management routes
    Route::prefix('admin/courses')->name('admin.courses.')->group(function () {
        Route::livewire('/', 'admin.courses.index')->name('index');
        Route::livewire('/create', 'admin.courses.create')->name('create');
        Route::livewire('/{course}/edit', 'admin.courses.edit')->name('edit');
        Route::livewire('/{course}/playlist', 'admin.courses.playlist')->name('playlist');
    });
});

require __DIR__.'/settings.php';
