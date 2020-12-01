<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $guarded = [];

//    protected $hidden = ['pivot'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function delegates()
    {
        return $this->belongsToMany(Delegate::class, 'delegate_user_zone')->withPivot('user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'delegate_user_zone')->withPivot('delegate_id');
    }

}
