<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'playlist_id',
        'course_id',
        'section_id',
        'title',
        'slug',
        'video_url',
        'is_preview',
        'is_published',
        'sort_order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_completed')
            ->withTimestamps();
    }

    public function starredByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_stars')->withTimestamps();
    }
}
