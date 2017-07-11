<?php
namespace App\Service;

use Illuminate\Support\Facades\Hash;

class JwtManager{

    private $header = [
        "alg" => "LaravelHashFacade",
        "typ" => "JWT"
    ];

    public function generateToken($payload){
      $headerHash = base64_encode(json_encode($this->header));
      $payloadHash = base64_encode(json_encode($payload));
      $token = Hash::make($headerHash."<->".$payload);
      return $token;
    }

}