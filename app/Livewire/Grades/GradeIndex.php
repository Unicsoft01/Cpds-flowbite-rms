<?php

namespace App\Livewire\Grades;

use App\Livewire\Forms\UpdateRecords;
use App\Models\Grades;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy()]
class GradeIndex extends Component
{
    public UpdateRecords $updatePrompt;
    public $grades;

    #[Validate('required|string')]
    public $a;
    #[Validate('required|numeric|max:100')]
    public $a_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $a_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $a_grade_point;

    #[Validate('required')]
    public $b;
    #[Validate('required|numeric|max:100')]
    public $b_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $b_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $b_grade_point;

    #[Validate('required')]
    public $c;
    #[Validate('required|numeric|max:100')]
    public $c_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $c_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $c_grade_point;

    #[Validate('required')]
    public $d;
    #[Validate('required|numeric|max:100')]
    public $d_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $d_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $d_grade_point;

    #[Validate('required')]
    public $e;
    #[Validate('required|numeric|max:100')]
    public $e_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $e_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $e_grade_point;

    #[Validate('required')]
    public $f;
    #[Validate('required|numeric|max:100')]
    public $f_lower_bound;
    #[Validate('required|numeric|max:100')]
    public $f_upper_bound;
    #[Validate('required|numeric|max:10')]
    public $f_grade_point;


    public function mount()
    {
        $this->grades = Grades::find(1);

        $this->a = $this->grades->a;
        $this->a_lower_bound = $this->grades->a_lower_bound;
        $this->a_upper_bound = $this->grades->a_upper_bound;
        $this->a_grade_point = $this->grades->a_grade_point;

        $this->b = $this->grades->b;
        $this->b_lower_bound = $this->grades->b_lower_bound;
        $this->b_upper_bound = $this->grades->b_upper_bound;
        $this->b_grade_point = $this->grades->b_grade_point;

        $this->c = $this->grades->c;
        $this->c_lower_bound = $this->grades->c_lower_bound;
        $this->c_upper_bound = $this->grades->c_upper_bound;
        $this->c_grade_point = $this->grades->c_grade_point;

        $this->d = $this->grades->d;
        $this->d_lower_bound = $this->grades->d_lower_bound;
        $this->d_upper_bound = $this->grades->d_upper_bound;
        $this->d_grade_point = $this->grades->d_grade_point;

        $this->e = $this->grades->e;
        $this->e_lower_bound = $this->grades->e_lower_bound;
        $this->e_upper_bound = $this->grades->e_upper_bound;
        $this->e_grade_point = $this->grades->e_grade_point;

        $this->f = $this->grades->f;
        $this->f_lower_bound = $this->grades->f_lower_bound;
        $this->f_upper_bound = $this->grades->f_upper_bound;
        $this->f_grade_point = $this->grades->f_grade_point;
    }


    protected $listeners = [
        'swal' => '$refresh'
    ];


    public function updateGrades()
    {
        $this->validate();
        $this->grades->update($this->validate());
        $this->dispatch(
            'swal',
            $this->updatePrompt->Swal()
        );

        // $this->redirectRoute('admin.homepage');
    }

    public function render()
    {
        return view('grades.grade-index');
    }
}
