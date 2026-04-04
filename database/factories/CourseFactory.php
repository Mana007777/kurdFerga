<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(2),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'technology'),
            'is_published' => true,
        ];
    }
}
