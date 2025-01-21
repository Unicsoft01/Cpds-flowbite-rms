<?php

namespace App\Traits;

trait SharedMethods
{
    public function MakeClass()
    {
        $levelMapping = [
            1 => ['level_id' => 1, 'semester_id' => 1],
            2 => ['level_id' => 1, 'semester_id' => 2],
            3 => ['level_id' => 2, 'semester_id' => 1],
            4 => ['level_id' => 2, 'semester_id' => 2],
        ];

        $this->level_id = $levelMapping[$this->level]['level_id'] ?? null;
        $this->semester_id = $levelMapping[$this->level]['semester_id'] ?? null;

        return ['level' => $this->level_id, 'sem' => $this->semester_id];
    }

    public function sortBy($col)
    {
        if ($this->orderBy === $col) {
            $this->sortDir = ($this->sortDir == "desc") ? "asc" : "desc";
            return;
        }

        $this->orderBy = $col;
        $this->sortDir = "asc";
    }
}