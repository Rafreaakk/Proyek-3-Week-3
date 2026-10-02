<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = ['id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
