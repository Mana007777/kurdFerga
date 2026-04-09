<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('lessons', 'duration_seconds')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->unsignedInteger('duration_seconds')->default(0)->after('video_url');
            });
        }

        if (! Schema::hasColumn('lesson_user', 'watched_seconds')) {
            Schema::table('lesson_user', function (Blueprint $table) {
                $table->unsignedInteger('watched_seconds')->default(0)->after('is_completed');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lessons', 'duration_seconds')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dropColumn('duration_seconds');
            });
        }

        if (Schema::hasColumn('lesson_user', 'watched_seconds')) {
            Schema::table('lesson_user', function (Blueprint $table) {
                $table->dropColumn('watched_seconds');
            });
        }
    }
};
