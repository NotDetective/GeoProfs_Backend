<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'date_leave'=> $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_return' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'reason' => $this->faker->optional()->sentence,
        ];
    }
}
