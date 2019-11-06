<?php

namespace App\Models;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\DBController;
use Exception;
use Firebase\JWT\JWT;

class TokenModel
{
    private $tokenizer;

    public function __construct(Request $request)
    {
        // double md5 hashing, why not?
        $this->setTokenizer(md5(md5("{$request->header('email')}{$request->header('pass')}{$request->header('nome')}")));  
    }

    private function setTokenizer($value)
    {
        $this->tokenizer = $value;
    }

    private function getTokenizer()
    {
        return $this->tokenizer;
    }

    public function generateToken(Request $request)
    {
        try{
            $db = new DBController;
            if ($this->tokenizer != null) {
                if ($db->recordToken($request,$this->getTokenizer())) {
                    return response()->json([
                        'Status' => 'Registered',
                        'token' => $this->getTokenizer()
                    ]);    
                } else {
                    return response()->json([
                        "error" => "An errer occurred during token register"
                    ], 400);
                }
            } else {
                return response()->json([
                    "error" => "An errer occurred during token generation",
                ], 400);
            }
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
    }

    public function checkToken(Request $request)
    {
        $db = new DBController;
        return $db->compareToken($request);
    }
}
?>