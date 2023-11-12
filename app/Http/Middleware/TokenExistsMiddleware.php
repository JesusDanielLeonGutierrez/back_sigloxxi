<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenExistsMiddleware
{
    protected function tokenExists(string $token): bool
    {
        $token = $this->parseToken($token);
        $token = trim($token, 'Bearer ');
//        dd($token);
        $tokenModel = PersonalAccessToken::where('id', $token)->first();

        if (! $tokenModel) {
            return false;
        }

        return true;
    }

    protected function parseToken(string $token): string
    {
        $pos = strpos($token, '|');

        if ($pos === false) {
            return $token;
        } else {
            return substr($token, 0, $pos);
        }
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }

        $token = $this->parseToken($token);

        $exists = $this->tokenExists($token);

        if (!$exists) {
            return response()->json([
                'message' => 'Invalid token',
                'status' => 401
            ], 401);
        }
////
//        dd($exists);
        return $next($request);
    }
}
