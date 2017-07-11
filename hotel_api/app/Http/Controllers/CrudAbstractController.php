<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Optional;
use App\Message;

abstract class CrudAbstractController extends Controller
{

/*
=====================================================
Listas com filtro query string
    exemplo cidade e estado!
        /cidade?orderBy=id&orderType=desc&
            orderBy : campo que deve ser ordenado
            orderType : type de ordenação, ascendente ou decrescente
=====================================================
*/


    /*
     * Get class reference
     * @return Model::class 
     */
    public abstract function getClass();

    /*
    * Validate put/post fields
    */
    public abstract function validateFields(Request $r);

    /*
    * Switch what GET method will be returned
    */
    public function dispatcher(Request $r, $id = null){
        
        $orderBy = $r->get("orderBy");

        $orderType = $r->get("orderType");

        if(empty($id)){
            return $this->list($r, $orderBy, $orderType);
        }

        return $this->get($r, $id);
    }

    /*
     * Get model list
     * @return Model::all()
     */
    public function list(Request $r, $orderBy = null, $orderType = null){
        
        try{
            $return;
            if(!empty($orderBy)){
                if(!empty($orderType)){
                    $return = $this->getClass()::orderBy($orderBy, $orderType)->get();                    
                }else{
                    $return = $this->getClass()::orderBy($orderBy)->get();
                }
            }else{
                $return = $this->getClass()::all();
            }
            return response(json_encode($return), 200)
                ->header('Content-Type', 'text/json');
        }catch(\Exception $e){
            $err = new Message();
            return response($err->getInternalError(), 500)
                ->header('Content-Type', 'text/json');
        }
    }
    
    /*
     * Get model single
     * @return Model::find($id)
     */
    public function get($r, $id){
        try{
            return response($this->getClass()::find($id), 200)
                ->header("Content-Type", "text/json");
        }catch(\Exception $e){
            $err = new Message();
            return response($err->getInternalError(), 500)
                ->header('Content-Type', 'text/json');
        }
    }

    /*
     * Store model
     * @return Model
     */
    public function store(Request $r, $id = null){
         try{
            $class = $this->getClass();
            $model = $class::find($id);
            if(empty($model)){
                $model = new $class;
            }
            $valid = $this->validateFields($r);
            if($valid === true){
                $model->fill(json_decode($r->getContent(), true));
                $model->save();
                return response(json_encode($model), 200)
                        ->header('Content-Type', 'text/json');
            }
            return response(json_encode($valid, true), 400)
                        ->header('Content-Type', 'text/json');
        }catch(\Exception $e){
            $err = new Message();
            return response($err->getInternalError(), 500)
                ->header('Content-Type', 'text/json');
        }
    }

    /*
     * Delete model
     * @return Message->getSuccessDelete()
     */
    public function delete($id){
        try{
            $class = $this->getClass();
            $class::destroy($id);
            $msg = new Message();
            return response(json_encode($msg->getSuccessDelete()), 200)
                    ->header('Content-Type', 'text/json');
        }
        catch( \Exception $e){
            $err = new Message();
            return response($err->getInternalError(), 500)
                ->header('Content-Type', 'text/json');
        }
    }
}