<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationForm extends Model
{
    use SoftDeletes;

    protected $table = 'application_forms';
    protected $fillable = [
        'medal_id',
        'file',
    ];

    public function medal()
    {
        return $this->belongsTo(Medal::class);
    }
}
