<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('users can authenticate', function () {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'password'
    ])->assertOk()
        ->assertJson([
            'email' => $user->email
        ]);

    $this->assertAuthenticated();
});

test('users cannot authenticate with invalid credentials', function () {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password'
    ])->assertInvalid(['email' => 'do not match']);

    $this->assertGuest();
});
