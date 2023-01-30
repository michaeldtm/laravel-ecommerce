<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

it('allows new users to register', function () {
    Event::fake();

    $this->postJson(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertOk()
        ->assertJson([
            'message' => __('user.created_successfully')
        ]);

    Event::assertDispatched(Registered::class);
});

it('requires valid data when registering', function ($data, $errors) {
    User::factory()->unverified()->create(['email' => 'test@example.com']);

    $this->postJson(route('register'), $data)->assertInvalid($errors);
})->with([
    'name missing' => [['name' => null], ['name' => 'required']],
    'email missing' => [['email' => null], ['email' => 'required']],
    'email not an email' => [['email' => 'foo'], ['email' => 'valid email address']],
    'email already exists' => [['email' => 'test@example.com'], ['email' => 'taken']],
    'password missing' => [['password' => null], ['password' => 'required']],
    'password not confirmed' => [['password_confirmation' => null], ['password' => 'required']]
]);
