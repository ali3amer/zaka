<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
