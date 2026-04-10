<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'author_name',
        'level',
        'category',
        'is_published',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function paths(): BelongsToMany
    {
        return $this->belongsToMany(Path::class)
            ->withPivot('order');
    }

    public function enrolledUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'playlist_user')->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
