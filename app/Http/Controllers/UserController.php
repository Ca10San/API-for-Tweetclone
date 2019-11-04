<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\AuthModel;

Class UserController{
    public function register(Request $request)
    {
        // getting all data from headers
        $email = $request->header('email');
        $pass = $request->header('pass');
        $nome = $request->header('nome');

        $db = new DBController();
        // if the Name and Email check returns true, insert data
        if(!$db->checkName($request)){
            response()->json(array([
                'Status' => 'Error',
                'ERROR' => 'Error: esse nome já foi utilizado escolha outro'
            ]));
        }elseif (!$db->checkEmail($request)) {
            response()->json(array([
                'Status' => 'Error',
                'ERROR' => 'Error: esse email já foi utilizado digite outro'
            ]));
        }elseif (condition) {
            $db->registerUser($request);
            $auth = new AuthModel($request);
            return $auth->createToken();
            //After registering an user, generates an token to it and returns if success
        }
    }
}

?>