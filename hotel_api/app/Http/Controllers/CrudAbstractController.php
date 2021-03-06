<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Optional;
use App\Message;
use App\Library\Constantes;

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
    * Get list by user type, get from ApiCrud Middleware
    */
    public abstract function listByUser(Request $r, $query);

    /*
    * Validate if an user can get de resource by id of path param
    * used on /resource/{id} routes
    */
    public abstract function userCanGetById(Request $r, $id);

    /*
    * Switch what GET method will be returned
    */
    public function dispatcher(Request $r, $id = null){
        
        $orderBy = $r->get("orderBy");

        $orderType = $r->get("orderType");

        if(empty($id)){
            if($r->input("user")->user_type == Constantes::USER_TYPE_ADMIN){
                return $this->list($this->getOrderQuery($orderBy, $orderType));
            }
            return $this->listByUser($r, $this->getOrderQuery($orderBy, $orderType));
        }
        if($this->userCanGetById($r, $id)){
            return $this->get($r, $id);
        }
        
        $err = new Message();
        return response(json_encode($err->getCustomMessage("err", "Este endpoint não está autorizado para seu usuário")), 401)
                ->header("Content-type", "text/json");
    }

    /*
     * Get an model instance query ordered 
     */
    public function getOrderQuery($orderBy = null, $orderType = null){
        if(!empty($orderBy)){
            if(!empty($orderType)){
                return $this->getClass()::orderBy($orderBy, $orderType);                    
            }else{
                return $this->getClass()::orderBy($orderBy);
            }
        }
        $class = $this->getClass();
        return new $class;
    }

    /*
     * Get model list
     * @return Model::all()
     */
    public function list($list){
        try{
            $list = $list->get();
            if(count($list) == 0){
                $err = new Message();
                return response(json_encode($err->getCustomMessage("err", 'Nenhum resultado para consulta')), 404)
                    ->header('Content-Type', 'text/json');    
            }
            return response(json_encode($list), 200)
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
            $query = $this->getClass()::find($id);
            if(empty($query)){
                $err = new Message();
                return response(json_encode($err->getCustomMessage("err", 'Nenhum resultado para consulta')), 404)
                    ->header('Content-Type', 'text/json');    
            }
            return response($query, 200)
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