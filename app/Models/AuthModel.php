<?php

namespace App\Models;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TokenModel;
use App\Http\Controllers\DBController;

class AuthModel
{
    private $request;

    public function __construct(Request $request)
    {
        $this->setRequest($request);        
    }

    public function getRequest(){
        return $this->request;
    }

    public function setRequest(Request $request){
        $this->request = $request;
    }

    // os métodos abaixo chamam o TokenModel
    // Para gerar os Tokens ou buscar os Tokens criados pelos usuarios
    public function createToken()
    {
        $token = new TokenModel($this->getRequest());
        return $token->generateToken($this->getRequest());
    }

    public function checkToken()
    {
        $db = new DBController;
        return $db->checkToken($this->request);
    }

    public function returnToken()
    {
        $db = new DBController;
        return $db->returnToken($this->request);
    }

    public function compareToken()
    {
        $db = new DBController;
        return $db->compareToken($this->request);
    }
}
?>