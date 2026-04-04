<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('a newly created user defaults to the student role', function () {
    $user = User::factory()->create();
    $user->refresh(); // Hydrate the DB schema default value into the object

    expect($user->role)->toBe('student')
        ->and($user->isStudent())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse();
});

test('a user can explicitly be designated as an admin', function () {
    $user = User::factory()->create(['role' => 'admin']);

    expect($user->role)->toBe('admin')
        ->and($user->isAdmin())->toBeTrue()
        ->and($user->isStudent())->toBeFalse();
});
