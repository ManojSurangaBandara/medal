<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
            'id',
            'service_no',
            'name',
            'email',
            'email_verified_at',
            'password',
            'remember_token',
            'active_date_time',
            'active',
            'created_at',
            'updated_at',
            'regiment_id',
            'role_id',
            'rank_id',
            'unit_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ranks()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function regiments()
    {
        return $this->belongsTo(Regiment::class, 'regiment_id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
       

    }
    public function rtype()
    {
        return $this->belongsTo(Rtype::class, 'rtype_id');
    }
}
