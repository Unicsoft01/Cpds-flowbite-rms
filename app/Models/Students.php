<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Students extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\StudentsFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guard = 'student';

    protected $primaryKey = 'student_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'middlename',
        'firstname',
        'set',
        'regno',
        'programme_id',
        'faculty_id',
        'dept_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Dept::class, 'dept_id');
    }

    public function courseRegistrations(): HasMany
    {
        return $this->hasMany(CourseRegisterations::class, 'student_id');
    }

    // public function studentsWithScores(): HasMany
    // {
    //     return $this->hasMany(Scores::class, 'student_id');
    // }

    public function studentsWithScores(): HasManyThrough
    {
        return $this->hasManyThrough(Scores::class, CourseRegisterations::class, 'student_id', 'score_id', 'student_id', 'registration_id');
    }

    public function scopeSearchStudent($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('surname', 'like', $term)
            ->orWhere('middlename', 'like', $term)
            ->orWhere('firstname', 'like', $term)
            ->orWhere('regno', 'like', $term);
        });
    }
}