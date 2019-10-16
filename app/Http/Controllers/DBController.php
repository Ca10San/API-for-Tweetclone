<?php

namespace App\Http\Controllers;

// if (PHP_SAPI != 'cli') 
// {
//     // isso aqui verifica se o arquivo ta rodando a partir de um terminal
//     // cli-server ------servidor
//     // cli -------terminal
//     exit('Error 404');
// }

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function adicionar(Request $request,$nome)
    {
        $teste = $request->input('nome');
        DB::table('usuarios')->insert(['teste' => $nome]);
        var_dump($teste);
    }

    public function remover(Request $request,$id)
    {
        $teste = $request->input('nome');
        DB::table('usuarios')->where('id','=',$id)->delete();
        var_dump($teste.'-'.$id);
    }

    // returns true if the user have a token
    // returns false if the user do not have a token
    public function checkToken(Request $request)
    {
        $token = DB::table('usuarios')
                        ->select('token')
                        ->whereRaw('email = ?',$request->header('email'))
                        ->whereRaw('senha = ?',$request->header('pass'))
                        ->first();
        
        if($token == '' || $token == null){
            return false;
        }else{
            return true;
        }
    }

    // grava no banco de dados o Token gerado
    // na linha do usuario informado no request
    public function recordToken(Request $request,$token)
    {
        DB::table('usuarios')
            ->whereRaw('email = ?',$request->header('email'))
            ->whereRaw('senha = ?',$request->header('pass'))
            ->update(['token' => $token]);
    }

    // retorna o Token do usuario que esta gravado no banco de dados
    public function returnToken(Request $request)
    {
        $token = DB::table('usuarios')
                        ->select('token')
                        ->whereRaw('email = ?',$request->header('email'))
                        ->whereRaw('senha = ?',$request->header('pass'))
                        ->get();
        return json_encode($token[0]);
    }

    // compara o token informado com o que esta gravado no banco
    public function compareToken(Request $request)
    {
        // buscando no banco de dados o token
        $token = DB::table('usuarios')
                        ->select('token')
                        ->whereRaw('token = ?',$request->header('Api-Token'))
                        ->first();

        if($token == '' || $token == null){
            return false;
        }else{
            return true;
        }
    }
}

?>