<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservationStatus;
use App\Reservation;
use App\Message;
use App\Library\Constantes;

class ReservationController extends CrudAbstractController
{
    //
    public function getClass(){
        return Reservation::class;
    }

    /*
     * @override
     */
    public function listByUser(Request $r, $query){
        try{
            $return = $query::where('user_id', '=', $r->input("user")->id)
            ->get(); 
            return response(json_encode($return), 200)
                ->header('Content-Type', 'text/json');
        }catch(\Exception $e){
            $err = new Message();
            return response($err->getInternalError(), 500)
                ->header('Content-Type', 'text/json');
        }
    }

    /*
     * @override
     */
    public function validateFields(Request $r){
        return true;
    }
    
    /*
     * @override
     */
    public function userCanGetById(Request $r, $id){
        return true;
    }
}
