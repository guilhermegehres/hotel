<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $table = "reservation";

    protected $fillable = [
        "reservation_start_date" ,
        "reservation_end_date",
        "reservation_total_value",
        "reservation_descount" ,
        "reservation_descount_reason",
        "apartament_id",
        "reservation_status_id",
        "user_id",
    ];

    public function guest()
    {
        return $this->belongsToMany('App\Guest', "guest_reservation");
    }

    public function status()
    {
        return $this->belongsTo('App\ReservationStatus', "reservation_status_id");
    }

    public function user()
    {
        return $this->belongsTo('App\User', "user_id");
    }
}
