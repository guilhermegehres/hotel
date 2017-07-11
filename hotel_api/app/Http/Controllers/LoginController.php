<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Message;
use App\Service\JwtManager;


class LoginController extends Controller
{
    /*
    * expects = {
        user_email : "email@example.com",
        user_password : "example pass"
    }
    */

    private $msg;
    private $jwtM;

    function __construct(){
        $this->msg = new Message();

        $this->jwtM = new JwtManager();
    }

    public function login(Request $r){
        $r = json_decode($r->getContent());
        $email = $r->user_email;
        $password = $r->user_password;

        $user = User::where("user_email", "=", $email)
        ->where("user_password", "=", $password)
        ->first();
        if(empty($user)){
            return response(json_encode($this->msg->getCustomMessage("err", "Login ou senha inválidos"), true), 400)
                        ->header('Content-Type', 'text/json');
        }

        $user->user_token = $this->jwtM->generateToken($user);

        $user->save();

        return response(json_encode($user, true), 200)
                        ->header('Content-Type', 'text/json');
    }
}
