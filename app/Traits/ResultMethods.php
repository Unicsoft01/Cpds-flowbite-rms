<?php

namespace App\Traits;

use App\Models\AcademicSessions;
use DB;

trait ResultMethods
{

    protected function SelectionResults()
    {
        // Validate selected students
        if (empty($this->checked)) {
            session()->flash('error', 'Please select at least one student belonging to a department, class and set to view results.');
            return;
        }

        if (!$this->set) {
            session()->flash('error', 'Select a valid session to continue.');
            return;
        }

        if (!$this->determineClass($this->level)['sem']) {
            session()->flash('error', 'Select a valid semester to continue.');
            return;
        }

        if (!$this->determineClass($this->level)['sem']) {
            session()->flash('error', 'Select a valid level to continue.');
            return;
        }

        if (!$this->dept_id) {
            session()->flash('error', 'Select a valid department to continue.');
            return;
        }
        // Log::debug("students: ", [$this->checked]);
        // Redirect to results page with selected student IDs

    }

    protected function released()
    {
        // Validate selected students
        if (empty($this->checked)) {
            session()->flash('error', 'Please select at least one student to release results.');
            return;
        }

        if (!$this->set) {
            session()->flash('error', 'Select a valid session to continue.');
            return;
        }

        if (!$this->determineClass($this->level)['sem']) {
            session()->flash('error', 'Select a valid semester to continue.');
            return;
        }

        if (!$this->determineClass($this->level)['level']) {
            session()->flash('error', 'Select a valid level to continue.');
            return;
        }

        if (!$this->dept_id) {
            session()->flash('error', 'Select a valid department to continue.');
            return;
        }

        try {
            // Update `result_status` to 1 for the selected students
            DB::table('course_registerations')
                ->whereIn('student_id', $this->checked)
                ->where('session_id', $this->set)
                ->where('level_id', $this->determineClass($this->level)['level'])
                ->where('semester_id', $this->determineClass($this->level)['sem'])
                ->update(['result_status' => 1]);

            // Flash success message
            session()->flash('success', 'Results have been successfully released for the selected students.');
        } catch (\Exception $e) {
            // Handle errors
            Log::error('Error releasing results:', ['error' => $e->getMessage()]);
            session()->flash('error', 'An error occurred while releasing results. Please try again.');
        }
    }

    protected function getCoreCourses()
    {
        return DB::table('courses')
            ->where('dept_id', $this->dept->dept_id)
            ->where('status', 'C') // Only core courses
            ->where(function ($query) {
                $this->applyLevelAndSemesterFilter($query, $this->level, $this->semester);
            })
            ->pluck('course_id'); // Return only course IDs
    }

    protected function getRegisteredCourses($student)
    {
        $coreCourseIds = $this->getCoreCourses(); // Fetch all core courses dynamically

        return DB::table('course_registerations')
            ->where('student_id', $student->student_id)
            ->whereIn('course_id', $coreCourseIds) // Only include core courses
            ->pluck('course_id'); // Return registered course IDs
    }

    protected function getCarryoverCourses($student)
    {
        return DB::table('course_registerations')
            ->join('courses', 'course_registerations.course_id', '=', 'courses.course_id')
            ->where('course_registerations.student_id', $student->student_id)
            ->where('courses.status', 'C') // Only core courses
            ->where(function ($q) {
                // Carryover conditions: grade_point < 1, grade == 'F', or no score
                $q->where('course_registerations.grade_point', '<', 1)
                    ->orWhere('course_registerations.grade', '=', 'F')
                    ->orWhereNull('course_registerations.score');
            })
            ->where(function ($query) {
                // Scenario 1: Diploma1, Semester1 -> No previous records
                if ($this->level === "diploma1" && $this->semester === "first") {
                    $query->where('course_registerations.level_id', '=', 1)
                        ->where('course_registerations.semester_id', '=', 1);
                }

                // Scenario 2: Diploma1, Semester2 -> Fetch Diploma1, Semester1
                elseif ($this->level === "diploma1" && $this->semester === "second") {
                    $query->where('course_registerations.level_id', '=', 1)
                        ->whereIn('course_registerations.semester_id', [1, 2]);
                }

                // Scenario 3: Diploma2, Semester1 -> Fetch Diploma1 (Semester1 & Semester2)
                elseif ($this->level === "diploma2" && $this->semester === "first") {
                    $query->where(function ($q2) {
                        $q2->where('course_registerations.level_id', '=', 1)
                            ->whereIn('course_registerations.semester_id', [1, 2]);
                    })->orWhere(function ($q2) {
                        $q2->where('course_registerations.level_id', '=', 2)
                            ->where('course_registerations.semester_id', '=', 1);
                    });
                }

                // Scenario 4: Diploma2, Semester2 -> Fetch Diploma1 (Sem1 & Sem2) and Diploma2 (Sem1)
                elseif ($this->level === "diploma2" && $this->semester === "second") {
                    $query->where('course_registerations.level_id', '<=', 2)
                        ->whereIn('course_registerations.semester_id', [1, 2]);
                }
            })
            ->pluck('courses.course_id'); // Fetch only course IDs
    }

    protected function applyLevelAndSemesterFilter($query, $currentLevel, $currentSemester)
    {
        // Dynamic filter for level and semester
        if ($currentLevel === "diploma1" && $currentSemester === "first") {
            $query->where('level_id', 1)
                ->where('semester_id', 1);
        } elseif ($currentLevel === "diploma1" && $currentSemester === "second") {
            $query->where('level_id', 1)
                ->whereIn('semester_id', [1, 2]);
        } elseif ($currentLevel === "diploma2" && $currentSemester === "first") {
            $query->where(function ($q2) {
                $q2->where('level_id', 1)
                    ->whereIn('semester_id', [1, 2]);
            })->orWhere(function ($q2) {
                $q2->where('level_id', 2)
                    ->where('semester_id', 1);
            });
        } elseif ($currentLevel === "diploma2" && $currentSemester === "second") {
            $query->where('level_id', '<=', 2)
                ->whereIn('semester_id', [1, 2]);
        }
    }

    protected function CurrentSession($set, $level)
    {
        if (!$set || !$level) {
            session()->flash('error', 'Please Select a Level/Semester.');
            return;
        }

        $ses = AcademicSessions::select('session')->find($set)->session;

        if ($level == 1) {
            return $ses;
        } else {
            return $ses; // + 1;
        }
    }
}