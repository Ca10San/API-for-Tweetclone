<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function() use ($router)
{
    return $router->app->version();
});

// o index 'as' da rota define um nome para router que pode ser chamado por redirect posteriormente
$router->get('/teste',[function() use ($router){
    return 'esse é um teste';
}, 'as' => 'teste']);

// o {} torna variavel a inserção do id
// o [] tornal opcional a inclusão daquele campo porem a inclusao de determinado campo tem de ser ao fim do endereço
$router->get('/hello[/{id}[/{nome}]]', function($id='teste',$nome='teste')
{ 
    return response()->json(['name' => $nome, 'state' => $id]);
});

// alocando as informações dessa forma voce recebe uma lista de atributos via get
// exemplo => localhost/lista/item1/item2/item3/item4
// o resultado do exemplo abaixo será um array contendo os dados que foram separados por "/"
$router->get('/lista/{itens:.*}', [function($itens)
{
    var_dump(explode('/',$itens));
}, 'as' => 'lista']);

// redirect para chamar uma outra  rota com outro nome, nomeada por 'as' no index
$router->get('/redirecionar',function()
{
    return redirect()->route('teste');
});


$router->get('/redirecionarlista',function()
{
    return redirect()->route('lista',['itens' => 'item1/item2/item3']);
});


// para acessar essas rotas é necessário a inclusao do prefixo descito
// por exemplo : teste_prefixo/teste ou teste_prefixo/prefixo
$router->group(['prefix' => 'teste_prefixo'],function() use ($router)
{
    $router->get('teste',function()
    {
        return 'deu certo, prefixo funcional';
    });

    $router->get('prefixo',function()
    {
        return 'deu certo, prefixo continua funcional';
    });
});

$router->post('/usuarios', function(Request $request)
{
    $teste = $request->input('nome');
    
    var_dump($teste);
});

$router->get('/usuarios', [function()
{
    var_dump($_GET);
}, 'middleware' => 'teste']);

$router->put('/usuarios/add/{nome}', 'DBController@adicionar');

$router->delete('/usuarios/delete/{id}', 'DBController@remover');
