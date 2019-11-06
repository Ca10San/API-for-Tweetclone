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
        try{
            $token = DB::table('usuarios')
                            ->select('token')
                            ->whereRaw('email = ?',$request->header('email'))
                            ->whereRaw('senha = ?',md5($request->header('pass')))
                            ->first();
            return response()->json($token);
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    // compara o token informado com o que esta gravado no banco
    public function compareToken(Request $request)
    {
        try{
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
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    // Email and Name checking will return true if didn't find any data in DB
    public function checkEmail(Request $request)
    {
        try{
            $emailChecked = DB::table('usuarios')
                                ->select('email')
                                ->whereRaw('email = ?',$request->header('email'))
                                ->first();
            
            if($emailChecked == '' || $emailChecked == null){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function checkName(Request $request)
    {
        try{
            $nameChecked = DB::table('usuarios')
                                ->select('nome')
                                ->whereRaw('nome = ?',$request->header('nome'))
                                ->first();
            
            if($nameChecked == '' || $nameChecked == null){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function registerUser(Request $request)
    {
        DB::table('usuarios')
            ->insert([
                'nome' => $request->header('nome'), 
                'senha' => md5($request->header('pass')), 
                'email' => $request->header('email')
            ]);
    }

    public function followUser($token,$name)
    {
        try{
            $id = $this->findUser($token,$name);

            DB::table('usuarios_seguidores')
                ->insert(array(
                    'id_usuario' => $id['id_usuario'],
                    'id_usuario_seguindo' => $id['id_usuario_seguindo']
                ));
            
            return response()->json([
                "Status" => "Success"
            ]);
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function unfollowUser($token,$name)
    {
        try{
            $id = $this->findUser($token,$name);

            DB::table('usuarios_seguidores')
                ->whereRaw('id_usuario = ?', $id['id_usuario'])
                ->whereRaw('id_usuario_seguindo = ?', $id['id_usuario_seguindo'])
                ->delete();
            
            return response()->json([
                "Status" => "Success"
            ]);
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function findUser($token,$name)
    {
        $id_usuario = DB::table('usuarios')
                        ->select('id')
                        ->whereRaw('token = ?',$token)
                        ->first();
        
        $id_usuario_seguindo = DB::table('usuarios')
                        ->select('id')
                        ->whereRaw('nome = ?',$name)
                        ->first();
        
        return array(
            "id_usuario" => $id_usuario->id,
            "id_usuario_seguindo" => $id_usuario_seguindo->id
        );                
    }
}

?>