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
        "kind" => "success"
    ];

    private $customMessage;

    public function getInternalError(){
        return $this->internalError;
    }
    public function getSuccessDelete(){
        return $this->successDelete;
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
