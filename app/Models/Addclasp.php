<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addclasp extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'id',
        'person_id',
        'medal_id',
        'clasp_profile_id',
        'rtype_id',
        'date',
        'file',
        'person_name',
        'person_rank',
        'is_un',
        'country_id',
        'to',
        'from',
    ];

    protected $hidden = [];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function medal()
    {
        return $this->belongsTo(Medal::class, 'medal_id');
    }

    public function clasp_profile()
    {
        return $this->belongsTo(ClaspProfile::class, 'clasp_profile_id');
    }

    public function rtype()
    {
        return $this->belongsTo(Rtype::class, 'rtype_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
