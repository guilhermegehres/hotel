<?php

namespace App;

class Message
{
    //
    private $internalError = [
        "message" => "Ops, Houve um erro interno!",
        "kind" => "err"
    ];

    private $successDelete = [
        "message" => "Deletado com sucesso",
        "kind" => "err"
    ];

    private $customMessage;

    public function getInternalError(){
        return json_encode($this->internalError);
    }
    public function getSuccessDelete(){
        return json_encode($this->successDelete);
    }

    public function setCustomMessage($message){
        //$this->customMessage["message"] = $message;
        array_push($this->customMessage,$message);
    }

    public function getCustomMessage($kind, $message){
        return [
            "message" => $message,
            "kind" => $kind
        ];
    }


}
