<?php

use App\Models\User;
use App\Models\Lesson;
use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Volt;

it('displays videos watched on a selected date', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $playlist = Playlist::factory()->create(['title' => 'Test Playlist']);
    $lesson1 = Lesson::factory()->create(['title' => 'Video 1', 'playlist_id' => $playlist->id]);
    $lesson2 = Lesson::factory()->create(['title' => 'Video 2', 'playlist_id' => $playlist->id]);

    $date = Carbon::now()->format('Y-m-d');
    
    // Simulate watching videos today
    DB::table('lesson_user')->insert([
        ['user_id' => $user->id, 'lesson_id' => $lesson1->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ['user_id' => $user->id, 'lesson_id' => $lesson2->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ]);

    // Simulate watching a video yesterday
    $yesterday = Carbon::yesterday();
    $lesson3 = Lesson::factory()->create(['title' => 'Yesterday Video', 'playlist_id' => $playlist->id]);
    
    DB::table('lesson_user')->insert([
        ['user_id' => $user->id, 'lesson_id' => $lesson3->id, 'created_at' => $yesterday, 'updated_at' => $yesterday],
    ]);

    $this->actingAs($user);

    $component = \Livewire\Livewire::test('pages::activity');

    // Initially should show today's videos (if we default mount to today)
    $component->assertSee('Video 1')
        ->assertSee('Video 2')
        ->assertSee('Test Playlist');

    // Select yesterday
    $component->call('selectDate', $yesterday->format('Y-m-d'))
        ->assertSee('Yesterday Video')
        ->assertSee(route('playlists.show', $playlist->slug))
        ->assertDontSee('Video 1');
});
