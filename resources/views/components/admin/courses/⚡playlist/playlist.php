<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Course $course;

    #[Validate('required|min:2', as: 'section title')]
    public $newSectionTitle = '';

    public $newLessonTitle = '';

    public $newLessonVideo;

    public $newLessonIsPreview = false;

    public $activeSectionIdForLesson = null;

    public $search = ''; // Realtime Filter Search

    public function mount(Course $course)
    {
        $user = auth()->user();
        abort_if(! $user || ! $user->isAdminOrInstructor(), 403);
        
        // Instructors can only manage courses in their own playlists
        if ($user->isInstructor()) {
            abort_if($course->playlist->user_id !== $user->id, 403);
        }

        $this->course = $course;
    }

    public function addSection()
    {
        $this->validateOnly('newSectionTitle');

        $maxSort = $this->course->sections()->max('sort_order') ?? 0;

        $this->course->sections()->create([
            'title' => $this->newSectionTitle,
            'sort_order' => $maxSort + 1,
        ]);

        $this->newSectionTitle = '';
        $this->dispatch('section-added');
        $this->course->refresh();
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
            'newLessonVideo' => 'required|file|mimes:mp4,mov,avi,webm|max:102400', // 100MB Validation
        ], [], ['newLessonTitle' => 'lesson title', 'newLessonVideo' => 'video file']);

        $section = Section::findOrFail($this->activeSectionIdForLesson);
        $maxSort = $section->lessons()->max('sort_order') ?? 0;

        // Store the video physically on the drive
        $path = $this->newLessonVideo->store('videos', 'public');

        $section->lessons()->create([
            'course_id' => $this->course->id,
            'title' => $this->newLessonTitle,
            'slug' => Str::slug($this->newLessonTitle),
            'video_url' => '/storage/'.$path, // Save relative mapped URL
            'is_preview' => $this->newLessonIsPreview,
            'is_published' => true,
            'sort_order' => $maxSort + 1,
        ]);

        $this->activeSectionIdForLesson = null;
        $this->dispatch('lesson-added');
        $this->course->refresh();
    }

    public function deleteSection($id)
    {
        Section::where('id', $id)->where('course_id', $this->course->id)->delete();
        $this->course->refresh();
    }

    public function deleteLesson($id)
    {
        Lesson::where('id', $id)->where('course_id', $this->course->id)->delete();
        // The physical video is not cleared via filesystem here to ensure safe deletions for history mapping, unless explicit Storage::delete is favored!
        $this->course->refresh();
    }

    public function with(): array
    {
        return [
            'sections' => $this->course->sections()->with(['lessons' => function ($query) {
                // Incorporate dynamic search filter
                if (! empty($this->search)) {
                    $query->where('title', 'like', '%'.$this->search.'%');
                }
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get(),
        ];
    }
};
