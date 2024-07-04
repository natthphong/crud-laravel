<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWT;

class IsAdmin
{
    protected $jwt;

    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Incoming Request:', [
            'method' => $request->method(),
            'uri' => $request->getRequestUri(),
            'headers' => $request->headers->all(),
        ]);

        try {

            if (!$token = $this->jwt->parseToken()->getToken()) {
                return response()->json(['error' => 'Token not provided'], 401);
            }


           $payload =  $this->jwt->manager()->decode($token);
            $user = new User;
            $user->id = $payload['sub'];
            $user->name = $payload['name'];
            $user->email = $payload['email'];
//            print_r($user->email);
//
            $request->merge(['auth_user' => $user]);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        return $next($request);
    }
}
