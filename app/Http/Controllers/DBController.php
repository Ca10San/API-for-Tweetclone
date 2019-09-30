<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::table('tabela_teste')->insert(['teste' => $nome]);
        var_dump($teste);
    }

    public function remover(Request $request,$id)
    {
        $teste = $request->input('nome');
        DB::table('tabela_teste')->where('id','=',$id)->delete();
        var_dump($teste.'-'.$id);
    }

    //
}

?>