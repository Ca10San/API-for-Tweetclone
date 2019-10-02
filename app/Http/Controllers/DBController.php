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
use App\Models;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DBController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function criartabela(){
        Schema::dropIfExists('tabela_teste23232').
        
        Schema::create('tabela_teste23232', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome_teste');
            $table->integer('idade');
        });
    }

    public function adicionar(Request $request,$nome)
    {
        $teste = $request->input('nome');
        DB::table('tabela_teste')->insert(['teste' => $nome]);
        var_dump($teste);
    }

    public function remover(Request $request,$id)
    {
        $teste = $request->input('nome');
        DB::table('tabela_teste')->where('id','=',$id)->delete();
        var_dump($teste.'-'.$id);
    }

    // returns true if the user have a token
    // returns false if the user do not have a token
    public function checkToken(Request $request)
    {
        $token = DB::table('tabela_teste')
                        ->select('token')
                        ->whereRaw('email = ?',$request->header('email'))
                        ->whereRaw('senha = ?',$request->header('password'))
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
        DB::table('tabela_teste')
            ->whereRaw('email = ?',$request->header('email'))
            ->whereRaw('senha = ?',$request->header('password'))
            ->update(['token' => $token]);
    }

    // retorna o Token do usuario que esta gravado no banco de dados
    public function returnToken(Request $request)
    {
        $token = DB::table('tabela_teste')
                        ->select('token')
                        ->whereRaw('email = ?',$request->header('email'))
                        ->whereRaw('senha = ?',$request->header('password'))
                        ->get();
        return json_encode($token[0]);
    }

    // compara o token informado com o que esta gravado no banco
    public function compareToken(Request $request)
    {
        // buscando no banco de dados o token
        $token = DB::table('tabela_teste')
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