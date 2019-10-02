<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

// if (PHP_SAPI != 'cli') 
// {
//     // isso aqui verifica se o arquivo ta rodando a partir de um terminal
//     // cli-server ------servidor
//     // cli -------terminal
//     exit('Error 404');
// }

class TesteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // o nome da função tem que ser handle
    public function handle($request, Closure $next)
    {
        echo 'teste de middleware ';
        return $next($request);
    }
}
?>