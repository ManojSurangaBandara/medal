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
        return $this->hasmany(Person::class);
    }



}
