<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Unit extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'unit', 
        'regiment_id'
         
    ];

    public function user()
    {
        return $this->hasmany(User::class);
    }

    public function person()
    {
        return $this->hasmany(Person::class);
    }

    public function regiments()
{
    return $this->belongsTo(Regiment::class, 'regiment_id', 'id');
}

}
