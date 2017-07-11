<?php
namespace App\Service;

use Illuminate\Support\Facades\Hash;

use App\User;


class JwtManager{

    private $header = [
        "alg" => "base64",
        "typ" => "JWT"
    ];

    public function generateToken($payload){
      $headerHash = base64_encode(json_encode($this->header));
      $payloadHash = base64_encode(json_encode($payload));
      $token = base64_encode($headerHash."<->".$payload);
      return $token;
    }

    public function getUserByToken($token){
        $tokenToVerifyOnDb = $token;
        $token = base64_decode($token);
        $token = explode("<->", $token);
        $token[0] = base64_decode($token[0]);
        $payloadHash = json_decode($token[1]);
        $headerHash = json_decode($token[0]);
        if($headerHash->alg !== "base64" && $headerHash->typ !== "JWT"){
            return false;    
        }

        $user = User::where("user_email", '=',$payloadHash->user_email)->first();
        if(empty($user)){
            return false;
        }
        if($user->user_token === $tokenToVerifyOnDb){
            return $user;
        }
        return false;
    }
}