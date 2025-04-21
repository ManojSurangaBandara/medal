<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'permissions';

    protected $fillable = [
        'id',
        'name',
        // 'guard_name',
        // 'created_at',
        // 'updated_at',
        
    ];

    protected $attributes = [
        'guard_name' => 'web',
    ];
    public function role(){
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }
}
