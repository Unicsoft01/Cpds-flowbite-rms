<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

    protected $primaryKey = 'level_id';

    protected $fillable = ['level', 'programme_id'];

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'program_id');
    }

    
    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class, 'level_id');
    }
}