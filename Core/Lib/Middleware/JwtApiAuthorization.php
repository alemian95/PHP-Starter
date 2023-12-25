<?php

namespace Core\Lib\Middleware;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class JwtApiAuthorization extends Middleware
{
    /**
     * 
     */
    public function resolve() : bool | Response
    {

        if (! preg_match('/Bearer\s(\S+)/', request()->headers->get('Authorization') ?? "", $matches))
        {
            return (new JsonResponse([
                'message' => "Authorization header not found in request"
            ]))->setStatusCode(403);
        }

        $jwt = $matches[1];

        if (! $jwt)
        {
            return (new JsonResponse([
                'message' => "Bearer token not found"
            ]))->setStatusCode(403);
        }

        try {
            
            $key = env('JWT_SECRET');
            JWT::decode($jwt, new Key($key, 'HS256'));
        }
        catch (Exception $e)
        {
            return (new JsonResponse([
                'message' => "Bearer token not valid or is expired"
            ]))->setStatusCode(403);
        }

        return true;
    }
}