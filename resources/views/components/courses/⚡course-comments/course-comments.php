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

    public ?int $replyingTo = null;

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
            'parent_id' => $this->replyingTo,
        ]);

        $this->body = '';
        $this->replyingTo = null;
        $this->dispatch('comment-posted');
    }

    public function setReply(int $commentId): void
    {
        $this->replyingTo = $commentId;
        $this->body = '';
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->body = '';
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);
        $user = Auth::user();

        if (! $user) {
            return;
        }

        // Admins can delete any comment. Others can only delete their own.
        if (! $user->isAdmin() && $comment->user_id !== $user->id) {
            return;
        }

        $comment->delete();
    }

    public function with(): array
    {
        return [
            'comments' => $this->course->comments()
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->latest()
                ->get(),
        ];
    }
};
