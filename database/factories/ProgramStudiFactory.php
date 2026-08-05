<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramStudiFactory extends Factory
{
    protected $model = ProgramStudi::class;

    public function definition(): array
    {
        return [
            'faculty_id' => Faculty::factory(),
            'level'      => fake()->randomElement(['S1', 'S2', 'S3', 'D3', 'D4']),
            'name'       => fake()->words(3, true),
        ];
    }
}
