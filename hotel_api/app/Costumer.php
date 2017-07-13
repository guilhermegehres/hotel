<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    //
    protected $table = "costumer";

     protected $fillable = [
        "costumer_name" ,
        "costumer_fantasy_name",
        "costumer_cpf",
        "costumer_cnpj" ,
        "costumer_street",
        "costumer_address_number",
        "costumer_address_description",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function apartament(){
        return $this->hasMany("App\Apartament", "apartament_type_id", 'id');
    }
}
