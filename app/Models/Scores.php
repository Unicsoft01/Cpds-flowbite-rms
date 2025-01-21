<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scores extends Model
{
    /** @use HasFactory<\Database\Factories\ScoresFactory> */
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'score_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['registration_id', 'user_id','score','grade_point','grade'];


    public function StudentsWithScores(): HasMany
    {
        return $this->hasMany(Students::class, 'student_id');
    }

    public function regDetails(): BelongsTo
    {
        return $this->belongsTo(CourseRegisterations::class, 'registration_id');
    }
}