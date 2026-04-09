<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'FergaSecurePass2026!',
        'password_confirmation' => 'FergaSecurePass2026!',
    ]);

    $user = User::where('email', 'test@example.com')->first();

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('password cannot contain name or email', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'JohnDoeSecurePass2026!',
        'password_confirmation' => 'JohnDoeSecurePass2026!',
    ]);

    $response->assertSessionHasErrors(['password']);

    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'johndoe12345!',
        'password_confirmation' => 'johndoe12345!',
    ]);

    $response->assertSessionHasErrors(['password']);
});
