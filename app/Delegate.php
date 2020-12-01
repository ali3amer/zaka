<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'delegate_user_zone')->withPivot('zone_id');
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'delegate_user_zone')->withPivot('user_id');
    }
}
