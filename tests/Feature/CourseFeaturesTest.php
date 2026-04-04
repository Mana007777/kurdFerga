<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can add comments, star, and save a course', function () {
    $user = User::factory()->create();
    $course = Course::create([
        'title' => 'Test Course',
        'slug' => 'test-course',
        'description' => 'A test course',
        'thumbnail' => null,
        'is_published' => true,
    ]);

    // Test comments
    $comment = Comment::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'body' => 'Great course!',
    ]);

    expect($course->comments)->toHaveCount(1);
    expect($course->comments->first()->body)->toBe('Great course!');
    expect($user->comments)->toHaveCount(1);
    
    // Test stars
    $user->starredCourses()->attach($course);
    // Refresh relationships
    $user->load('starredCourses');
    $course->load('stars');
    expect($user->starredCourses)->toHaveCount(1);
    expect($course->stars)->toHaveCount(1);
    
    // Test saves
    $user->savedCourses()->attach($course);
    // Refresh relationships
    $user->load('savedCourses');
    $course->load('saves');
    expect($user->savedCourses)->toHaveCount(1);
    expect($course->saves)->toHaveCount(1);
});
