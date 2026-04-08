<?php

namespace Database\Seeders;

use App\Models\Path;
use Illuminate\Database\Seeder;

class PathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = Path::create([
            'title' => 'Mastering Backend Engineering',
            'slug' => 'mastering-backend-engineering',
            'description' => 'A structured path from Java OOP concepts to building powerful web applications with PHP. Perfect for those who want to understand the foundations and the application.',
            'is_published' => true,
        ]);

        $path->playlists()->attach([
            1 => ['order' => 1], // JAVA OOP
            2 => ['order' => 2], // PHP
        ]);
    }
}
