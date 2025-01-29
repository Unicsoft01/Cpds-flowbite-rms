<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseRegisterations extends Model
{
    /** @use HasFactory<\Database\Factories\CourseRegisterationsFactory> */
    use HasFactory;

    protected $primaryKey = 'registration_id';

    protected $fillable = [
        'semester_id',
        'student_id',
        'course_id',
        'session_id',
        'level_id',
        'registered_by',

        'is_carryover',
        'is_spillover',
        'result_status',

        'user_id',
        'score',
        'grade_point',
        'grade'
    ];

    public function students(): BelongsTo
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function courses(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
    public function sessions(): BelongsTo
    {
        return $this->belongsTo(AcademicSessions::class, 'session_id');
    }

    public function levels(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function semesters(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Scores::class, 'score_id');
    }
}