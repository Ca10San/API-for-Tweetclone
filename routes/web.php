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

// first contact with the API
$router->get('/', function() use ($router)
{
    return response('Welcome to Tweetclone API, register yourself into /users/register and get your token, if have you already registered go directly in /token instead!', phpinfo());
});

// returns the Token
$router->get('/token','AuthController@token');

// Creating an user and returning his token
$router->post('/users/register','UserController@register');

// to get into API functions the user had to be ssuccessfully registered into system
$router->group(['prefix' => '/API', 'middleware' => 'auth'],function() use ($router)
{   
    // group for functions relationed to users
    $router->group(['prefix' => '/users'],function()use($router){
        $router->put('/follow/{id}', 'DBController@follow');

        $router->delete('/unfollow/{id}', 'DBController@unfollow');
    });

    
    $router->get('/teste',[function() use ($router){
        return response()->json(["teste" => "voce esta autenticado"]);
    }]); 
});


// EVERYTHING BELOW IS JUST ANNOTATIONS


// o index 'as' da rota define um nome para router que pode ser chamado por redirect posteriormente
// $router->get('/teste',[function() use ($router){
//     $array = array("teste" => "esse é um teste");
//     return response()->json($array);
// }, 'as' => 'teste']);

// // o {} torna variavel a inserção do id
// // o [] tornal opcional a inclusão daquele campo porem a inclusao de determinado campo tem de ser ao fim do endereço
// $router->get('/hello[/{id}[/{nome}]]', function($id='teste',$nome='teste')
// { 
//     return response()->json(['name' => $nome, 'state' => $id]);
// });

// // alocando as informações dessa forma voce recebe uma lista de atributos via get
// // exemplo => localhost/lista/item1/item2/item3/item4
// // o resultado do exemplo abaixo será um array contendo os dados que foram separados por "/"
// $router->get('/lista/{itens:.*}', [function($itens)
// {
//     var_dump(explode('/',$itens));
// }, 'as' => 'lista']);

// // redirect para chamar uma outra  rota com outro nome, nomeada por 'as' no index

// $router->get('/redirecionarlista',function()
// {
//     return redirect()->route('lista',['itens' => 'item1/item2/item3']);
// });

// $router->get('/redirecionar',function()
//     {
//         return redirect()->route('teste');
//     });

// // para acessar essas rotas é necessário a inclusao do prefixo descito
// // por exemplo : teste_prefixo/teste ou teste_prefixo/prefixo
// $router->group(['prefix' => 'teste_prefixo'],function() use ($router)
// {
//     $router->get('teste',function()
//     {
//         return 'deu certo, prefixo funcional';
//     });

//     $router->get('prefixo',function()
//     {
//         return 'deu certo, prefixo continua funcional';
//     });
// });

// $router->get('/usuarios', function(Request $request,Response $response)
// {
//     $teste = DB::select('select * from usuarios');
//     return $teste;
// });

// $router->delete('/usuarios', [function(Request $request)
// {
//     var_dump($request);
// }, 'middleware' => 'teste']);

// $router->put('/criartabela',[function ()
// {
//     return 've la no banco se deu certo!';
// },'uses' => 'DBController@criartabela']);


