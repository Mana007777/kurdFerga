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
});

// Public Playlist browsing
Route::livewire('/playlists', 'playlists.index')->name('playlists.index');
Route::livewire('/playlists/{playlist}', 'playlists.show')->name('playlists.show');

Route::middleware(['auth'])->group(function () {
    Route::livewire('/stars', 'pages::stars')->name('stars.index');
    Route::livewire('/leaderboard', 'pages::leaderboard')->name('leaderboard');

    // Admin Playlist Management routes
    Route::prefix('admin/playlists')->name('admin.playlists.')->group(function () {
        Route::livewire('/', 'admin.playlists.index')->name('index');
        Route::livewire('/create', 'admin.playlists.create')->name('create');
        Route::livewire('/{playlist}/edit', 'admin.playlists.edit')->name('edit');
        Route::livewire('/{playlist}/courses', 'admin.playlists.courses')->name('courses');
    });

    // Admin Course Management routes
    Route::prefix('admin/courses')->name('admin.courses.')->group(function () {
        Route::livewire('/{course}/playlist', 'admin.courses.playlist')->name('playlist');
    });
});

require __DIR__.'/settings.php';
