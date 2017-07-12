<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Optional;
use App\Message;

class OptionalController extends CrudAbstractController
{

    private $fieldsToValidate = [
        'optional_name',
        'optional_description'
    ];

    private $msg;

    /*
     * @override
     */
    public function getClass(){
        return Optional::class;
    }

    /*
     * @override
     */
    public function listByUser(Request $r, $query){
        try{
            return response(json_encode($query), 200)
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
        if(empty($r->optional_name)){
            return $this->msg->getCustomMessage("err", 'O campo optional_name não pode ser vazio');
        }
        return true;
    }
     
}