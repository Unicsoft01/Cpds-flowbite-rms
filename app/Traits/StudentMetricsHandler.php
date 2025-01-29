<?php

namespace App\Traits;

trait StudentMetricsHandler
{
    protected function SetCarryover($registration)
    {
        $registration->update([
            'is_carryover' => 1,
        ]);
    }

    protected function checkAndSetCarryover($registration)
    {
        // Recalculate the grade point
        $gradePoint = $this->calculateGrade($registration->score)['point'];

        // Update the `is_spillover` field based on the grade point
        $registration->update([
            'is_carryover' => $gradePoint < 1, // Set to true if grade point is less than 1
        ]);
    }

    protected function checkAndSetSpillover($registration)
    {
        $gradePoint = $this->calculateGrade($registration->score)['point'];

        $registration->update([
            'is_spillover' => $gradePoint < 1,
        ]);
    }
}
