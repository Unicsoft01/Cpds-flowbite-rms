<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSessions extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicSessionsFactory> */
    use HasFactory;

    protected $primaryKey = 'session_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['session'];
}
