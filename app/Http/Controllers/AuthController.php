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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\AuthModel;
use App\Http\Controllers\DBController;


class AuthController extends Controller
{
    // essa função é chamada pela rota /token
    // recebo via request os headers de senha e usuario
    // e passo para outro controlador de Banco de dados
    // verificar se existe um token para aquele usuario
    // usando o método checkToken
    // e a partir dessa verificação executa algum metodo
    // vindo do AuthModel
    public function tokenizer(Request $request)
    {
        $db = new DBController;
        $auth = new AuthModel($request); 
        if ($db->checkToken($request)){
            return $auth->returnToken();
        }else{
            return  $auth->createToken();
        }
    }

    public function verifyAuth(Request $request)
    {
        $db = new DBController;
        if ($db->compareToken($request)) {
            return true;
        }else{
            return false;
        }
    }
}
?>