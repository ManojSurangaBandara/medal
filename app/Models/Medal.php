<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medal extends Model
{
    use SoftDeletes;

    protected $table = 'medals';
    protected $fillable = [
        'name',

    ];
}
