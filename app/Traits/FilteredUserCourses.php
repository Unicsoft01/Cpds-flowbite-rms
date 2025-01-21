<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use DB;

trait FilteredUserCourses
{
    public function getCourses($dept_id, $semester_id, $level_id)
    {
        // Start building the query
        $query = DB::table('courses')->where('user_id', Auth::id());

        // Apply filters dynamically
        if ($dept_id) {
            $query->where('dept_id', $dept_id);
        }

        if ($semester_id) {
            $query->where('semester_id', $semester_id);
        }

        if ($level_id) {
            $query->where('level_id', $level_id);
        }

        // Execute the query and return the results
        return $query->orderBy('course_code', 'asc')->get(['course_id', 'course_code', 'course_title']);
    }
}