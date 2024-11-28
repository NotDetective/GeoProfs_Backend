<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = $this->faker->word;
        return [
            'permissions_id' => Permission::factory(['name' => `manager ${name}`, 'system_name' => `manage_${name}`])->create()->id,
            'name' => $name,
        ];
    }
}
