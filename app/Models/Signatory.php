<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signatory extends Model
{
    use HasFactory;

    protected $primaryKey = 'signatory_id';

    protected $fillable = [
        'user_id',
        'hod',
        'exam_officer',
    ];

    public function Signatory_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}