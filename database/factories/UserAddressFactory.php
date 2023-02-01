<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        [$address, $details] = explode(PHP_EOL, $this->faker->address);
        [$city, $state_zipcode] = explode(',', trim($details));
        [$state, $zipcode] = explode(' ', trim($state_zipcode));

        return [
            'full_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address_1' => $address,
            'city' => $city,
            'state' => $state,
            'zipcode' => $zipcode,
            'default_address' => false,
        ];
    }

    /**
     * Indicate that the address is a default address.
     *
     * @return static
     */
    public function default_address(): static
    {
        return $this->state(fn (array $attributes) => [
            'default_address' => true,
        ]);
    }
}
