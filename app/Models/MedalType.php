<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MedalType extends Model
{
    use SoftDeletes;

    protected $table = 'medal_types';
    protected $fillable = [
        'medal_type',

    ];

    public function medals()
    {
        return $this->hasMany(Medal::class);
    }
}
