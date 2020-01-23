<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Notifications\Notifiable;

class Theme extends Model
{
    protected $guarded = [];

    use SoftDeletes;

//    use Notifiable;

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
