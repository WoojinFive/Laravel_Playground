<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    protected $guarded = [];

    use Notifiable;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
