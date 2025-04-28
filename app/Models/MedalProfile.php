<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedalProfile extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'medal_profiles';
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

    public function rtype()
    {
        return $this->belongsTo(Rtype::class, 'rtype_id');
    }
    public function medal()
    {
        return $this->belongsTo(Medal::class, 'medal_id');
    }
    
}
