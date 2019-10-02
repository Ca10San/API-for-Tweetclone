<?php

namespace App\Models;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TokenModel;
use App\Http\Controllers\DBController;

class AuthModel
{
    private $pass;
    private $email;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->pass = $this->request->header('password');
        $this->email = $this->request->header('email');
    }

    // os métodos abaixo chamam o TokenModel
    // Para gerar os Tokens ou buscar os Tokens criados pelos usuarios
    public function createToken()
    {
        $token = new TokenModel();
        return $token->generateToken($this->request);
    }

    public function returnToken()
    {
        $db = new DBController;
        return $db->returnToken($this->request);
    }
}
?>