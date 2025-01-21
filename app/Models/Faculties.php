<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculties extends Model
{
    /** @use HasFactory<\Database\Factories\FacultiesFactory> */
    use HasFactory;

    protected $primaryKey = 'faculty_id';

    protected $fillable = ['faculty'];

    public function deptsInFaculty(): HasMany
    {
        return $this->hasMany(Dept::class, 'dept_id');
    }
    public function scopeSearchFaculties($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('faculty', 'like', $term);
        });
    }
}
