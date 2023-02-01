<?php

use App\Models\User;
use App\Models\UserAddress;

it('allows to register a new user address', function () {
    $address = UserAddress::factory()->make();

    loginAsUser();

    $this->post(route('user.address'), $address->toArray())
        ->assertOk()
        ->assertJson([
            'message' => __('messages.user_address.created')
        ]);
});

it('allows to register a new user address but default address already exists', function () {
    $user = User::factory()
        ->has(UserAddress::factory()->default_address()->count(1), 'addresses')
        ->create();

    $firstAddress = $user->addresses->first();

    $address = UserAddress::factory()->make();

    loginAsUser($user);

    $this->post(route('user.address'), $address->toArray())
        ->assertOk()
        ->assertJson([
            'message' => __('messages.user_address.created')
        ]);

    $this->assertDatabaseCount('user_addresses', 2);
    $this->assertDatabaseHas('user_addresses', [
        'address_1' => $firstAddress->address_1,
        'default_address' => true,
    ]);
    $this->assertDatabaseHas('user_addresses', [
        'address_1' => $address->address_1,
        'default_address' => false,
    ]);
});
