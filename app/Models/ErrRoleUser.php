<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $primaryKey = 'role_user_id';

    protected $fillable = ['user_id', 'role_id'];
}