<?php

use App\Models\Path;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a path can have many playlists in a specific order', function () {
    $path = Path::create([
        'title' => 'Test Path',
        'slug' => 'test-path',
        'is_published' => true,
    ]);

    $playlist1 = Playlist::factory()->create(['title' => 'First']);
    $playlist2 = Playlist::factory()->create(['title' => 'Second']);

    $path->playlists()->attach([
        $playlist1->id => ['order' => 1],
        $playlist2->id => ['order' => 2],
    ]);

    expect($path->playlists)->toHaveCount(2);
    expect($path->playlists->first()->title)->toBe('First');
    expect($path->playlists->last()->title)->toBe('Second');
});

test('paths index page is accessible', function () {
    $this->get(route('paths.index'))->assertStatus(200);
});

test('path show page is accessible', function () {
    $path = Path::create([
        'title' => 'Test Path',
        'slug' => 'test-path',
        'is_published' => true,
    ]);

    $this->get(route('paths.show', $path->slug))->assertStatus(200);
});
