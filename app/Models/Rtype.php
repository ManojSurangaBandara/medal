<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rtype extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'rtype',


    ];


    public function person()
    {
        return $this->hasMany(Person::class);
    }
    public function addmedal(){
        return $this->hasMany(Addmedal::class);
    }

    public function medal_profiles(){
        return $this->hasMany(MedalProfile::class);
    }

    public function clasp_profiles(){
        return $this->hasMany(ClaspProfile::class);
    }


}
