<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Unit extends Model
{
    use SoftDeletes;
    protected $table = 'units';
    protected $fillable = [
        'unit',
        'regiment_id',

    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function person()
    {
        return $this->hasMany(Person::class);
    }

    public function regiments()
{
    return $this->belongsTo(Regiment::class, 'regiment_id', 'id');
}

}
