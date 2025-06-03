<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'persons';
    protected $fillable = [
            'id',
            'service_no',
            'eno',
            'name',
            'created_at',
            'updated_at',
            'regiment_id',
            'rank_id',
            'unit_id',
            'doe',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function regiment()
    {
        return $this->belongsTo(Regiment::class, 'regiment_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function addmedal(){
        return $this->hasMany(Addmedal::class,'person_id','id');
    }

    public function addclasp(){
        return $this->hasMany(Addclasp::class,'person_id','id');
    }

    public function clasps_profiles()
    {
        return $this->hasMany(ClaspProfile::class, 'person_id', 'id');
    }
}
