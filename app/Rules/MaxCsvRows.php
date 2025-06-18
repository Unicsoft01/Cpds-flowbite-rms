<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaxCsvRows implements Rule
{
    protected $maxRows;
    protected $actualRows;

    public function __construct($maxRows)
    {
        $this->maxRows = $maxRows;
    }

    public function passes($attribute, $value): bool
    {
        try {
            $spreadsheet = IOFactory::load($value->getRealPath());
            $sheet       = $spreadsheet->getActiveSheet();
            $this->actualRows = $sheet->getHighestRow();

            return $this->actualRows <= $this->maxRows;
        } catch (\Exception $e) {
            return false; // Fail silently if unreadable
        }
    }

    public function message(): string
    {
        return "The uploaded file exceeds the maximum rows ({$this->maxRows}). Please reduce rows and try again";
    }
}