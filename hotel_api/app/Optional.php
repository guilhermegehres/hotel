<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    //
    protected $table = 'optional';

    protected $fillable = ['id','optional_name', 'optional_description'];
    
    public $timestamps = false;
}
