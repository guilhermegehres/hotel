<?php

namespace App\Http\Middleware;


use App\Service\JwtManager;
use Closure;
use App\Message;
use App\Library\Constantes;

class Admin
{
    private $msg;

    function __construct(){
        $this->msg = new Message();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwt = new JwtManager();
        $user = $jwt->getUserByToken($request->header("Authorization"));
        if($user == false){
            return response(json_encode($this->msg->getCustomMessage("err", "Token inválido")), 400)
            ->header("Content-type", "text/json");
        }
        if($user->user_type != Constantes::USER_TYPE_ADMIN){
            return response(json_encode($this->msg->getCustomMessage("err", "Este endpoint não está autorizado para seu usuário")), 401)
                ->header("Content-type", "text/json");
        }
        return $next($request);
    }
}
