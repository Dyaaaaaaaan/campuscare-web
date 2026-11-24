<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class JwtMiddleware
{
    public function __construct(private readonly JwtService $jwtService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        try {
            $payload = $this->jwtService->verifyToken($token);
            $user = User::find($payload['sub'] ?? null);

            if (!$user) {
                return response()->json([
                    'message' => 'Token is invalid.',
                ], 401);
            }

            $request->setUserResolver(fn () => $user);
        } catch (Throwable) {
            return response()->json([
                'message' => 'Token is invalid.',
            ], 401);
        }

        return $next($request);
    }
}
