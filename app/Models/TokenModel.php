<?php

namespace App\Models;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\DBController;
use Firebase\JWT\JWT;

class TokenModel
{
    private $secretKey;
    private $tokenizer;

    public function __constructor(Request $request)
    {
        $this->secretKey = '8e74ceaf980d99078e9f2c60dc00cc813db40b72c370b80ed1d21203df93e5e4';
        $this->tokenizer = array(
            "email" => $request->header('email'),
            "password" => $request->header('password')
        );
    }

    public function generateToken(Request $request)
    {
        $tokenizer = JWT::encode($this->tokenizer,$this->secretKey);
        $db = new DBController;
        $db->recordToken($request,$tokenizer);
        return $tokenizer;
    }
}
?>