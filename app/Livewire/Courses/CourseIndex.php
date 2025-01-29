<?php

namespace App\Livewire\Courses;

use App\Exports\CoursesExport;
use App\Livewire\Forms\DeleteRecords;
use App\Models\Courses;
use App\Models\Dept;
use App\Models\Level;
use App\Models\Semester;
use App\Traits\SharedMethods;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

// use Maatwebsite\Excel\Facades\Excel;

#[Lazy()]
class CourseIndex extends Component
{
    use WithPagination;
    use SharedMethods;

    public DeleteRecords $deletePrompt;
    public $orderBy = "course_code";
    public $sortDir = "asc";

    public $selectAll = false; // select all students w
    public $checked = []; //selected student 

    #[Url]
    public $search = "";
    public $paginate = 100;

    #[Url]
    #[Computed()]
    public $dept_id = null;

    #[Url]
    #[Computed()]
    public $level = null;
    public $level_id = null;
    public $semester_id = null;

    public function setSortBy($col)
    {
        $this->sortBy($col);
    }

    public function indicateChecked($course_id)
    {
        return in_array($course_id, $this->checked);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->courses->pluck('course_id')->toArray(); // Select all results
        } else {
            $this->checked = []; // Deselect all results
        }
    }

    public function render()
    {
        return view('courses.course-index', [
            'courses' => $this->courses,
        ]);
    }

    #[Computed()]
    public function courses()
    {
        $this->MakeClass();

        $deptIds = Dept::where('user_id', Auth::id())->pluck('dept_id');

        // Start building the query
        $query = Courses::query()->with(['department', 'level', 'semester'])->where('user_id', Auth::id());


        if ($this->level_id &&  $this->semester_id) {
            $query->Where('semester_id', $this->semester_id)
                ->Where('level_id', $this->level_id);
            $this->level_id = null;
            $this->semester_id = null;
            $this->checked = null;
        }

        // Apply the department filter
        if ($this->dept_id) {
            $query->where('dept_id', $this->dept_id);
            $this->checked = [];
        } else {
            $query->whereIn('dept_id', $deptIds);
        }

        return $query->searchCourses(trim($this->search))
            ->orderBy($this->orderBy, $this->sortDir)
            ->simplePaginate($this->paginate);
    }


    public function OpenCreatePage()
    {
        $this->redirectRoute('course.create', navigate: true);
    }

    #[On('edit-course')]
    public function OpenEditPage($id)
    {
        $this->redirectRoute('course.edit', ['id' => $id], navigate: true);
    }

    protected $listeners = [
        'swal' => '$refresh'
    ];

    #[On('Confirm-Delete')]
    public function DeleteRecord($id)
    {
        $this->deletePrompt->DeleteRecord('App\Models\Courses', $id);

        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    #[On('Confirm-Export')]
    public function exportSelected()
    {
        return (new CoursesExport($this->checked))->download($this->generateFileName($this->dept_id, $this->semester_id, $this->level_id));
    }

    #[On('Confirm-Multiple-Delete')]
    public function deleteMultipleRecords()
    {
        if (empty($this->checked)) {
            session()->flash('error', 'Please select one or multiple Courses to delete');
            return;
        }
        Courses::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        // $this->selectPage = false;
        $this->dispatch(
            'swal',
            $this->deletePrompt->Swal()
        );
    }

    public function OpenImportView()
    {
        $this->redirectRoute('course.import', navigate: true);
    }


    public function generateFileName($dept_ = null, $semester_ = null, $level_ = null)
    {
        // course_registrations_CSC101_300_first_2023-2024.xlsx
        if ($dept_) {
            $dept_ = Dept::find($dept_)->department;
        }
        if ($semester_) {
            $semester_ = Semester::find($semester_)->sem;
        }
        if ($level_) {
            $level_ = Level::find($level_)->level;
        }


        return 'Courses_'
            . strtoupper(str_replace(' ', '_', $dept_)) . '_'
            . strtolower(str_replace(' ', '_', $semester_)) . '_Sem_'
            . strtolower(str_replace(' ', '_', $level_)) . ''
            . '_' . now()->format('m_d_His')
            . '.csv';
    }
}