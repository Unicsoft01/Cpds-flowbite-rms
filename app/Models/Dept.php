<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dept extends Model
{
    /** @use HasFactory<\Database\Factories\DeptFactory> */
    use HasFactory;

    protected $primaryKey = 'dept_id';

    protected $fillable = ['department', 'faculty_id', 'user_id'];

    public function facultyMember(): BelongsTo
    {
        return $this->belongsTo(Faculties::class, 'faculty_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'dept_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Courses::class, 'dept_id');
    }

    public function scopeSearchDepartments($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('department', 'like', $term);
        });
    }
}