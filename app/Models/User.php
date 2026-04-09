<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Concerns\HasTeams;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'pts', 'current_team_id', 'role', 'profile_photo_path'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasTeams, Notifiable, TwoFactorAuthenticatable;

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function starredCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_stars')->withTimestamps();
    }

    public function savedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'saved_courses')->withTimestamps();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function profilePhotoUrl(): string
    {
        return $this->profile_photo_path
            ? asset('storage/'.$this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
            ->withPivot(['is_completed', 'watched_seconds'])
            ->withTimestamps();
    }

    public function starredLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_stars')->withTimestamps();
    }

    public function completeLesson(Lesson $lesson, ?int $watchedSeconds = null): void
    {
        $existing = $this->completedLessons()->where('lesson_id', $lesson->id)->first();

        // Already fully completed (100% / 5pts)
        if ($existing && $existing->pivot->is_completed) {
            return;
        }

        // Calculate XP based on progress
        $duration = $lesson->duration_seconds > 0 ? $lesson->duration_seconds : 1;

        // If watchedSeconds is null, it means an explicit "Complete" click.
        // We use existing progress if available, otherwise 0.
        $watched = $watchedSeconds ?? ($existing ? $existing->pivot->watched_seconds : 0);
        $watched = min($watched, $duration);

        $ptsToAward = (int) floor(($watched / $duration) * 5);
        $isFullyCompleted = ($watchedSeconds === null) || ($watched === $duration);

        if ($existing) {
            $prevPts = (int) floor(($existing->pivot->watched_seconds / $duration) * 5);
            $newPts = $ptsToAward - $prevPts;

            if ($newPts > 0) {
                $this->increment('pts', $newPts);
            }

            $this->completedLessons()->updateExistingPivot($lesson->id, [
                'is_completed' => $isFullyCompleted,
                'watched_seconds' => $watched,
            ]);
        } else {
            $this->completedLessons()->attach($lesson, [
                'is_completed' => $isFullyCompleted,
                'watched_seconds' => $watched,
            ]);

            if ($ptsToAward > 0) {
                $this->increment('pts', $ptsToAward);
            }
        }
    }
}
