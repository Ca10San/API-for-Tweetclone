<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\AuthController;

Class UserController{
    public function register(Request $request){
        // getting all data from headers
        $email = $request->header('email');
        $pass = $request->header('pass');
        $nome = $request->header('nome');

        DB::table('usuarios')->insert(['nome' => $nome, 'pass' => md5($pass), 'email' => $email]);

        AuthController::tokenizer($request);
        //After registering an user, generates an token to it and returns if success
    }
}

?>