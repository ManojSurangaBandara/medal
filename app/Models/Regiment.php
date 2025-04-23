<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regiment extends Model
{
    use SoftDeletes;

    protected $table = 'regiments';
    protected $fillable = [
        'regiment',

    ];

    public function user()
    {
        return $this->hasmany(User::class);
    }

    public function person()
    {
        return $this->hasmany(Person::class);
    }
     public function units()
    {
        return $this->hasMany(Unit::class, 'unit_id');
    }
}
