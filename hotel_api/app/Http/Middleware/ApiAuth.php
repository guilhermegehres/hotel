<?php

namespace App\Http\Middleware;

use App\Service\JwtManager;
use Closure;
use App\Message;

class ApiAuth
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
        $request->merge(array("user" => $user));
        return $next($request);
    }
}
