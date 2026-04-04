<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < 4; $i++) {
            $title = $faker->sentence(rand(3, 6));
            $course = Course::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'description' => $faker->paragraph(2),
                'thumbnail' => $faker->imageUrl(640, 480, 'technology'),
                'is_published' => true,
            ]);
            
            for ($j = 0; $j < rand(10, 20); $j++) {
                $lessonTitle = $faker->sentence(rand(3, 8));
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => $lessonTitle,
                    'slug' => Str::slug($lessonTitle) . '-' . uniqid(),
                    'video_url' => 'https://example.com/video',
                    'is_preview' => false,
                    'is_published' => true,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
