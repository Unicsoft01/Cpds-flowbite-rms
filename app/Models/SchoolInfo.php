<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolInfoFactory> */
    use HasFactory;

    protected $primaryKey = 'school_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_name',
        'location',
        'logo'
    ];
}