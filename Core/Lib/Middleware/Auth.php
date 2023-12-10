<?php

namespace Core\Lib\Middleware;

use Symfony\Component\HttpFoundation\Response;

class Auth extends Middleware
{
    /**
     * 
     */
    public function resolve() : bool | Response
    {
        return (new Response("Abort"))->setStatusCode(401);
    }
}