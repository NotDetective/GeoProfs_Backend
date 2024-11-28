<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word . $this->faker->domainName;

        return [
            'permissions_id' => Permission::factory([
                'name' => 'Manager ' . $name,
                'system_name' => 'manager_' . $name,
            ])->create()->id,
            'name' => $name,
        ];
    }
}
