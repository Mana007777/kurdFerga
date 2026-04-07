<?php

use App\Models\Playlist;
use App\Models\User;
use function Pest\Laravel\get;

it('allows guests to view the playlists index', function () {
    Playlist::factory()->count(3)->create(['is_published' => true]);

    get(route('playlists.index'))
        ->assertOk()
        ->assertSee('All Playlists');
});

it('allows guests to view a playlist show page', function () {
    $playlist = Playlist::factory()->create([
        'title' => 'Test Playlist',
        'is_published' => true,
        'slug' => 'test-playlist'
    ]);

    get(route('playlists.show', $playlist))
        ->assertOk()
        ->assertSee('Test Playlist')
        ->assertSee('Playlist Overview');
});

it('shows lock icons for guests on playlist show page', function () {
    $playlist = Playlist::factory()->create(['is_published' => true]);
    $section = $playlist->sections()->create(['title' => 'Section 1', 'sort_order' => 1]);
    $section->lessons()->create([
        'title' => 'Locked Lesson',
        'slug' => 'locked-lesson',
        'video_url' => 'https://example.com/video',
        'is_published' => true,
        'sort_order' => 1
    ]);

    get(route('playlists.show', $playlist))
        ->assertOk()
        ->assertSee('Watch Vid')
        ->assertSee("alert('Please login first')", false);
});

it('allows authenticated users to see watch vid without lock', function () {
    $user = User::factory()->create();
    $playlist = Playlist::factory()->create(['is_published' => true]);
    $section = $playlist->sections()->create(['title' => 'Section 1', 'sort_order' => 1]);
    $section->lessons()->create([
        'title' => 'Accessible Lesson',
        'slug' => 'accessible-lesson',
        'video_url' => 'https://example.com/video',
        'is_published' => true,
        'sort_order' => 1
    ]);

    $this->actingAs($user)
        ->get(route('playlists.show', $playlist))
        ->assertOk()
        ->assertSee('Watch Vid')
        ->assertDontSee('lock-closed');
});
