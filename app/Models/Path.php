<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Path extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'thumbnail',
        'is_published',
    ];

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class)
            ->withPivot('order')
            ->orderByPivot('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
