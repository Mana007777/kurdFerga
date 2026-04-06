<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('playlist_id')
                ->after('course_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('playlist_id')
                ->after('course_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['playlist_id']);
            $table->dropColumn('playlist_id');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['playlist_id']);
            $table->dropColumn('playlist_id');
        });
    }
};
