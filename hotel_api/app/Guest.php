<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    //
    protected $table = "guest";

    public function reservation(){
        return $this->belongsToMany('App\Reservation', 'guest_reservation');
    }
}
