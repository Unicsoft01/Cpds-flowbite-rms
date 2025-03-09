<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousMetrics extends Model
{
    /** @use HasFactory<\Database\Factories\PreviousMetricsFactory> */
    use HasFactory;

    protected $primaryKey = 'metric_id';
    protected $fillable = [
        'tcr',
        'tce',
        'tgp',
        'gpa',
        'student_id',
    ];
}
