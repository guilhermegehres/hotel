<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartament extends Model
{
    //
    protected $table = "apartament";

    public function apartamentType(){
        return $this->belongsTo('App\ApartamentType', 'apartament_type_id');
    }

    public function costumer(){
        return $this->belongsTo('App\Costumer', 'costumer_id');
    }
}
