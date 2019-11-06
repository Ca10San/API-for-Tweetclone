<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\AuthModel;

Class UserController{
    public function register(Request $request)
    {
        try{
            // getting all data from headers
            $email = $request->header('email');
            $pass = $request->header('pass');
            $nome = $request->header('nome');

            $db = new DBController();
            // if the Name and Email check returns true, insert data
            if(!$db->checkName($request)){
                return response()->json(array(
                    'Status' => 'Error',
                    'ERROR' => 'Esse nome já foi utilizado escolha outro'
                ));
            }elseif (!$db->checkEmail($request)) {
                return response()->json(array(
                    'Status' => 'Error',
                    'ERROR' => 'Esse email já foi utilizado digite outro'
                ));
            }else{
                try{
                    $db->registerUser($request);
                    $auth = new AuthModel($request);
                    return $auth->createToken();
                }catch(Exception $e){
                    return response("Erro: ".$e->getMessage()."\n",400);
                }
                //After registering an user, generates an token to it and returns if success
            }
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function follow(Request $request, $name)
    {
        $db = new DBController;
        return $db->followUser($request->header('Api-Token'),$name);
    }

    public function unfollow(Request $request, $name)
    {
        $db = new DBController;
        return $db->unfollowUser($request->header('Api-Token'),$name);
    }
}
?>