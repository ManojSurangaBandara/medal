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
        'description',
        'medal_type_id',
        'image',
        'is_un',

    ];

    public function addmedal(){
        return $this->hasMany(Addmedal::class);
    }

    public function medal_type(){
        return $this->belongsTo(MedalType::class, 'medal_type_id');
    }
}
