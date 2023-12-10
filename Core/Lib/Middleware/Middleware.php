<?php

namespace Core\Lib\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Middleware
{

    protected array $params;
    protected ?Request $request;

    /**
     * 
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->request = null;
    }

    /**
     * 
     */
    public function requestParams(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 
     */
    public abstract function resolve() : bool | Response;
}