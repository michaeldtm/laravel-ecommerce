<?php

use App\Models\User;
use App\Models\UserAddress;

it('allows to register a new user address', function () {
    $address = UserAddress::factory()->make();

    loginAsUser();

    $this->post(route('user_address.store'), $address->toArray())
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

    $this->post(route('user_address.store'), $address->toArray())
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

it('allows to update an existing address', function () {
    $user = loginAsUser();

    $address = UserAddress::factory()->default_address()->for($user)->create();

    $this->put(route('user_address.update', $address->id), [
        ...$address->toArray(),
        'address_2' => '2nd address updated.'
    ])->assertOk()
        ->assertJson([
            'message' => __('messages.user_address.updated')
        ]);

    $this->assertDatabaseHas('user_addresses', [
        'address_2' => '2nd address updated.'
    ]);
});

it('allows to set another default address and remove current one', function () {
    $user = loginAsUser();

    $defaultAddress = UserAddress::factory()->default_address()->for($user)->create();

    $address = UserAddress::factory()->for($user)->create([
        'default_address' => false
    ]);

    $this->put(route('user_address.update', $address->id), [
        'default_address' => true
    ])->assertOk()
        ->assertJson([
            'message' => __('messages.user_address.updated')
        ]);

    $this->assertDatabaseHas('user_addresses', [
        'address_1' => $defaultAddress->address_1,
        'default_address' => false
    ]);

    $this->assertDatabaseHas('user_addresses', [
        'address_1' => $address->address_1,
        'default_address' => true
    ]);
});
