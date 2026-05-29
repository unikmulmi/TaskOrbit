<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            // $user = User::factory()->create();
            // $startDate = $this->faker->dateTimeBetween('-3mnths','now');
            // $endDate = $this->faker->dateTimeBetween($startDate ,'+1 year');

        return [
            // 'name' => $this->faker->sentence(3),
            // 'description' => $this->faker->paragraph(),
            // 'start_date' => $startDate,
            // 'end_date' => $endDate,
            // 'files' => [
            //     'projects/' . $this->faker->uuid . '.pdf',
            //     'projects/' . $this->faker->uuid . '.png',
            //     ],
            // 'status' => $this->faker->randomElement(['in_progress', 'pending' , 'cancelled' , 'completed' , 'on_hold']),
            // 'created_by' => $user->id,
            // 'updated_by' => $user->id,
        ];
    }
}
