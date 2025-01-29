<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    /** @use HasFactory<\Database\Factories\RolePermissionFactory> */
    use HasFactory;
    protected $primaryKey = 'role_permission_id';
    // Allow mass assignment for specific fields
    protected $fillable = ['role_id', 'permission_id', 'assigned_by', 'created_at'];
    
}