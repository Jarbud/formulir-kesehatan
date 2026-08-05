<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Fakultas Teknik',
                'Fakultas Ekonomi',
                'Fakultas Hukum',
                'Fakultas Kedokteran',
                'Fakultas MIPA',
                'Fakultas Ilmu Pendidikan',
                'Fakultas Pertanian',
                'Fakultas Sosial dan Politik',
            ]),
        ];
    }
}
