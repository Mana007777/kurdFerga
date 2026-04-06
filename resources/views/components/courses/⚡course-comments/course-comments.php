<?php

use App\Models\Course;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Course $course;

    #[Validate('required|min:3|max:1000')]
    public string $body = '';

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function postComment(): void
    {
        if (! Auth::check()) {
            return;
        }

        $this->validate();

        $this->course->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->dispatch('comment-posted');
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return;
        }

        $comment->delete();
    }

    public function with(): array
    {
        return [
            'comments' => $this->course->comments()->with('user')->latest()->get(),
        ];
    }
};
