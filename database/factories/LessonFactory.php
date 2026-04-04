<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 8));

        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'video_url' => 'https://example.com/video',
            'is_preview' => false,
            'is_published' => true,
            'sort_order' => 0,
        ];
    }
}
