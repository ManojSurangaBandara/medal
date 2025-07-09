<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';
    protected $fillable = [
        'country',

    ];

    public function addmedal(){
        return $this->hasMany(Addmedal::class);
    }
}
