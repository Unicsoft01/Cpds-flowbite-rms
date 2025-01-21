<?php

namespace App\Models;

use App\Enums\CourseStatus;
use App\Enums\CourseUnits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courses extends Model
{
    /** @use HasFactory<\Database\Factories\CoursesFactory> */
    use HasFactory;

    protected $primaryKey = 'course_id';

    protected $fillable =
    [
        'course_code',
        'course_title',
        'user_id',
        'dept_id',
        'level_id',
        'unit',
        'status',
        'semester_id',
    ];

    protected $casts = [
        // 'unit' => CourseUnits::class,
        // 'status' => CourseStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Dept::class, 'dept_id');
    }
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function courseRegistrations(): HasMany
    {
        return $this->hasMany(CourseRegisterations::class, 'course_id');
    }

    public function scopeSearchCourses($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('course_code', 'like', $term)
            ->orWhere('course_title', 'like', $term)
            ->orWhere('unit', 'like', $term)
            ->orWhere('status', 'like', $term);
        });
    }
}