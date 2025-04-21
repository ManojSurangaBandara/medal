<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
         
    ];


    
    public function user()
    {
        return $this->hasmany(User::class);
    }
    public function person()
    {
        return $this->hasmany(person::class);
    }

    
}
