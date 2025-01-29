<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Students;
use Carbon\Carbon;

class CodDashboard extends Component
{

    public $totalStudents;
    public $growthRate;

    public function mount()
    {
        $this->fetchStudentStats();
    }

    public function fetchStudentStats()
    {
        // Total students
        $this->totalStudents = Students::count();

        // Students from last month
        $lastMonthCount = Students::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        // Calculate growth rate percentage
        if ($lastMonthCount > 0) {
            $this->growthRate = round((($this->totalStudents - $lastMonthCount) / $lastMonthCount) * 100, 2);
        } else {
            $this->growthRate = 0;
        }
    }

    public function render()
    {
        return view('dashboard');
    }
}
