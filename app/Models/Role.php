<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'roles';

    protected $fillable = [
        'id',
        'name',
        // 'guard_name',
        
    ];

    // Define the many-to-many relationship with Permission
    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
