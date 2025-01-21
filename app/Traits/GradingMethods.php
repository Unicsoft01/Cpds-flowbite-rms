<?php

namespace App\Traits;

use App\Models\Grades;

trait GradingMethods
{
    public function calculateGrade($score)
    {
        // Fetch the grade thresholds from the database
        $grading = Grades::first();

        // Ensure the grading row exists
        if (!$grading) {
            throw new \Exception('Grade thresholds not found in the database.');
        }

        // Dynamically determine the grade and grade point
        if ($score >= $grading->a_lower_bound && $score <= $grading->a_upper_bound) {
            return ['grade' => 'A', 'point' => $grading->a_grade_point];
        } elseif ($score >= $grading->b_lower_bound && $score <= $grading->b_upper_bound) {
            return ['grade' => 'B', 'point' => $grading->b_grade_point];
        } elseif ($score >= $grading->c_lower_bound && $score <= $grading->c_upper_bound) {
            return ['grade' => 'C', 'point' => $grading->c_grade_point];
        } elseif ($score >= $grading->d_lower_bound && $score <= $grading->d_upper_bound) {
            return ['grade' => 'D', 'point' => $grading->d_grade_point];
        } elseif ($score >= $grading->e_lower_bound && $score <= $grading->e_upper_bound) {
            return ['grade' => 'E', 'point' => $grading->e_grade_point];
        } else {
            return ['grade' => 'F', 'point' => $grading->f_grade_point];
        }
    }
}
