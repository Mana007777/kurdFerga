<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Course $course;

    #[Validate('required|min:2', as: 'section title')]
    public $newSectionTitle = '';

    public $newLessonTitle = '';

    public $newLessonVideoUrl = '';

    public $newLessonIsPreview = false;

    public $activeSectionIdForLesson = null;

    public function mount(Course $course)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
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
        $this->newLessonVideoUrl = '';
        $this->newLessonIsPreview = false;
    }

    public function addLesson()
    {
        $this->validate([
            'newLessonTitle' => 'required|min:2',
            'newLessonVideoUrl' => 'required|url',
        ], [], ['newLessonTitle' => 'lesson title', 'newLessonVideoUrl' => 'video URL']);

        $section = Section::findOrFail($this->activeSectionIdForLesson);
        $maxSort = $section->lessons()->max('sort_order') ?? 0;

        $section->lessons()->create([
            'course_id' => $this->course->id,
            'title' => $this->newLessonTitle,
            'slug' => Str::slug($this->newLessonTitle),
            'video_url' => $this->newLessonVideoUrl,
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
        $this->course->refresh();
    }

    public function with(): array
    {
        return [
            'sections' => $this->course->sections()->with(['lessons' => function ($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get(),
        ];
    }
};
