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

    public function addclasp(){
        return $this->hasMany(Addclasp::class);
    }

    public function medal_type(){
        return $this->belongsTo(MedalType::class, 'medal_type_id');
    }

    public function medal_profiles(){
        return $this->hasMany(MedalProfile::class, 'medal_id');
    }

    public function clasp_profiles(){
        return $this->hasMany(ClaspProfile::class, 'medal_id');
    }

    public function application_forms(){
        return $this->hasMany(ApplicationForm::class, 'medal_id');
    }
}
