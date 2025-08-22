<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;

    protected $table = 'ranks';
    protected $fillable = ['name'];



    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function person()
    {
        return $this->hasMany(person::class);
    }
}
