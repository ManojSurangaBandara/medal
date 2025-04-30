<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addmedal extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'person_id',
        'medal_id',
        'medal_profile_id',
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function medal()
    {
        return $this->belongsTo(Medal::class, 'medal_id');
    }

    public function medal_profile()
    {
        return $this->belongsTo(MedalProfile::class, 'medal_profile_id');
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
