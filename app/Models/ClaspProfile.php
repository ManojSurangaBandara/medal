<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaspProfile extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $table = 'clasp_profiles';
    protected $fillable = [
        'id',
        'reference_no',
        'created_at',
        'updated_at',
        'deleted_at',
        'rtype_id',
        'date',
        'file',
        'status',
        'medal_id',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [];
    }

    public function rtype()
    {
        return $this->belongsTo(Rtype::class, 'rtype_id');
    }

    public function medal()
    {
        return $this->belongsTo(Medal::class, 'medal_id');
    }
}
