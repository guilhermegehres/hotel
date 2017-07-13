<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Message;
use App\Library\Constantes;

class UserController extends CrudAbstractController
{
    //
    public function getClass(){
        return User::class;
    }

    /*
     * @override
     */
    public function listByUser(Request $r, $query){
        try{
            return response(json_encode($query->get()), 200)
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
        $this->msg = new Message();
        $r = json_decode($r->getContent());
        $user = User::where("user_email", "=", $r->user_email)->first();
        if(count($user) > 0){
            return $this->msg->getCustomMessage("err", 'O campo user_email não pode ser vazio');
        }
        return true;
    }
    
    /*
     * @override
     */
    public function userCanGetById(Request $r, $id){
        if($r->input("user")->id == $id || $r->input("user")->user_type == Constantes::USER_TYPE_ADMIN){
            return true;
        }
    }
}
