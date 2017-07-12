<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartamentType extends Model
{
    //
    protected $table = "apartament_type";

    public function apartament(){
        return $this->hasMany("App\Apartament", "apartament_type_id", 'id');
    }
}
