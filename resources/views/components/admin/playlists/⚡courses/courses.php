<?php

use App\Models\Lesson;
use App\Models\Playlist;
use App\Models\Section;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Playlist $playlist;

    #[Validate('required|min:2', as: 'section title')]
    public $newSectionTitle = '';

    public $newLessonTitle = '';

    public $newLessonVideo;

    public $newLessonIsPreview = false;
    public $newLessonDurationMinutes = 0;

    public $activeSectionIdForLesson = null;

    public $search = '';

    public function mount(Playlist $playlist)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $this->playlist = $playlist;
    }

    public function addSection()
    {
        $this->validateOnly('newSectionTitle');

        $maxSort = $this->playlist->sections()->max('sort_order') ?? 0;

        $this->playlist->sections()->create([
            'title' => $this->newSectionTitle,
            'sort_order' => $maxSort + 1,
        ]);

        $this->newSectionTitle = '';
        $this->dispatch('section-added');
        $this->playlist->refresh();
    }

    public function openAddLessonModal($sectionId)
    {
        $this->activeSectionIdForLesson = $sectionId;
        $this->newLessonTitle = '';
        $this->newLessonVideo = null;
        $this->newLessonIsPreview = false;
    }

    public function addLesson()
    {
        $this->validate([
            'newLessonTitle' => 'required|min:2',
            'newLessonVideo' => 'required|file|mimes:mp4,mov,avi,webm|max:102400',
        ], [], ['newLessonTitle' => 'lesson title', 'newLessonVideo' => 'video file']);

        $section = Section::findOrFail($this->activeSectionIdForLesson);
        $maxSort = $section->lessons()->max('sort_order') ?? 0;

        $path = $this->newLessonVideo->store('videos', 'public');

        $section->lessons()->create([
            'playlist_id' => $this->playlist->id,
            'title' => $this->newLessonTitle,
            'slug' => Str::slug($this->newLessonTitle),
            'video_url' => '/storage/'.$path,
            'is_preview' => $this->newLessonIsPreview,
            'is_published' => true,
            'sort_order' => $maxSort + 1,
            'duration_seconds' => (int) ($this->newLessonDurationMinutes * 60),
        ]);

        $this->activeSectionIdForLesson = null;
        $this->dispatch('lesson-added');
        $this->playlist->refresh();
    }

    public function deleteSection($id)
    {
        Section::where('id', $id)->where('playlist_id', $this->playlist->id)->delete();
        $this->playlist->refresh();
    }

    public function deleteLesson($id)
    {
        Lesson::where('id', $id)->where('playlist_id', $this->playlist->id)->delete();
        $this->playlist->refresh();
    }

    public function with(): array
    {
        return [
            'sections' => $this->playlist->sections()->with(['lessons' => function ($query) {
                if (! empty($this->search)) {
                    $query->where('title', 'like', '%'.$this->search.'%');
                }
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get(),
        ];
    }
};
