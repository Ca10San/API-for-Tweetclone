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

    // grava no banco de dados o Token gerado
    // na linha do usuario informado no request
    public function recordToken(Request $request,$token)
    {
        DB::table('usuarios')
            ->whereRaw('email = ?',$request->header('email'))
            ->whereRaw('senha = ?',md5($request->header('pass')))
            ->update(['token' => $token]);
        return true;
    }

    // retorna o Token do usuario que esta gravado no banco de dados
    public function returnToken(Request $request)
    {
        $token = DB::table('usuarios')
                        ->select('token')
                        ->whereRaw('email = ?',$request->header('email'))
                        ->whereRaw('senha = ?',md5($request->header('pass')))
                        ->first();
        return response()->json($token);
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

    public function checkEmail(Request $request){
        $emailChecked = DB::table('usuarios')
                            ->select('email')
                            ->whereRaw('email = ?',$request->header('email'))
                            ->first();
        
        if($emailChecked == '' || $emailChecked == null){
            return false;
        }else{
            return true;
        }
    }

    public function checkName(Request $request){
        $nameChecked = DB::table('usuarios')
                            ->select('nome')
                            ->whereRaw('nome = ?',$request->header('nome'))
                            ->first();
        
        if($nameChecked == '' || $nameChecked == null){
            return false;
        }else{
            return true;
        }
    }

    public function registerUser(Request $request){
        DB::table('usuarios')
            ->insert([
                'nome' => $request->header('nome'), 
                'senha' => md5($request->header('pass')), 
                'email' => $request->header('email')]
            );
    }
}

?>