<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function view(Request $request)
    {
        // return $request;
        $student_id = $request->input('students');
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $level_id = $request->input('level_id');
        $dept_id = $request->input('dept_id');

        if (!$student_id) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        if (!$semester_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }

        if (!$level_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }


        return view('results.view', compact(['student_id', 'session_id', 'semester_id', 'level_id', 'dept_id']));
    }

    public function co_view(Request $request)
    {
        // return $request;
        $student_id = $request->input('students');
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $level_id = $request->input('level_id');
        $dept_id = $request->input('dept_id');

        if (!$student_id) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        if (!$semester_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }

        if (!$level_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }


        return view('carryover.results-view', compact(['student_id', 'session_id', 'semester_id', 'level_id', 'dept_id']));
    }

    // view of result page from external app
    public function viewResultFromOutSide(Request $request)
    {
        // return $request;
        $student_id = $request->input('students');
        $session_id = $request->input('session_id');
        $semester_id = $request->input('semester_id');
        $level_id = $request->input('level_id');
        $dept_id = $request->input('dept_id');

        if (!$student_id) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        if (!$semester_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }

        if (!$level_id) {
            return redirect()->back()->with('error', 'Select a valid class to continue');
        }

        return view('results.view-from-external-source', compact(['student_id', 'session_id', 'semester_id', 'level_id', 'dept_id']));
    }
}
