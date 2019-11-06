<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\TokenModel;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try{
            if (!is_null($request->header('Api-Token'))) {
                $tokenModel = new TokenModel($request);
                if($tokenModel->checkToken($request)){
                    return $next($request);
                }else{
                    return response()->json(['Status' => 'Unauthorized.'], 401);
                };
            }else{
                return response()->json(['Status' => 'Unauthorized.'], 401);
            }
        }catch(Exception $e){
            return response("Erro: ".$e->getMessage()."\n",400);
        }
        // if ($this->auth->guard($guard)->guest()) {
        //     return response()->json(['Status' => 'Unauthorized.'], 401);
        // }
    }
}
