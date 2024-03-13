<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'password' => bcrypt('password'),
        ];
    }

    public function password(string $password = 'secret'): UserFactory
    {
        return $this->state(function () use ($password) {
            return [
                'password' => bcrypt($password)
            ];
        });
    }
}
