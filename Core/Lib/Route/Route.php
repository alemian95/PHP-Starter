<?php

namespace Core\Lib\Route;

use Core\Lib\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Route
{

    const PARAM_INT_PLACEHOLDER = "{int}";
    const PARAM_INT_REGEX = "([0-9]+)";
    const PARAM_STRING_PLACEHOLDER = "{string}";
    const PARAM_STRING_REGEX = "([A-Za-z0-9-_%]+)";

    private string $method;
    private string $uri;
    private string $regex;
    

    private Controller $controller;
    private array $middlewares;
    private string $callback;

    /**
     * 
     */
    public function __construct($uri, $callback)
    {
        $this->uri = $uri;
        $this->callback = $callback;

        $this->uri = $uri;
        
        $this->regex = $uri;
        $this->regex = str_replace(static::PARAM_INT_PLACEHOLDER, static::PARAM_INT_REGEX, $this->regex);
        $this->regex = str_replace(static::PARAM_STRING_PLACEHOLDER, static::PARAM_STRING_REGEX, $this->regex);
        $this->regex = "#^$this->regex(?:\?(.*))?$#";

        $callback = explode('@', $callback);
        $class = "App\\Controllers\\" . $callback[0];
        $this->controller = new $class();
        $this->callback = $callback[1];

        $this->middlewares = [];
    }

    /**
     * 
     */
    public function method($method = null) : self | string
    {
        if ($method === null)
        {
            return $this->method;
        }

        $this->method = strtoupper($method);
        return $this;
    }

    /**
     * 
     */
    public function middlewares(array $middlewares)
    {
        foreach ($middlewares as $m)
        {

            $middleware = explode(":", $m);
            $params = explode(",", $middleware[1] ?? "");

            $class = "Core\\Lib\\Middleware\\" . $middleware[0];
            if (! class_exists($class))
            {
                $class = "App\\Middlewares\\" . $middleware[0];
            }
            $this->middlewares[] = new $class($params);
            
        }
        return $this;
    }

    /**
     * 
     */
    public function uri() : string
    {
        return $this->uri;
    }

    /**
     * 
     */
    public function regex() : string
    {
        return $this->regex;
    }

    /**
     * 
     */
    public function url($params) : string
    {
        $uri = $this->uri;
        $uri = str_replace(static::PARAM_INT_PLACEHOLDER, '{param}', $uri);
        $uri = str_replace(static::PARAM_STRING_PLACEHOLDER, '{param}', $uri);

        foreach ($params as $param)
        {
            $placeholder = '{param}';
            $uri = preg_replace("/$placeholder/", $param, $uri, 1);
        }

        return env('APP_URL') . $uri;
    }

    /**
     * 
     */
    public static function get($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('get');
    }

    /**
     * 
     */
    public static function post($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('post');
    }

    /**
     * 
     */
    public static function put($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('put');
    }

    /**
     * 
     */
    public static function patch($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('patch');
    }

    /**
     * 
     */
    public static function delete($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('delete');
    }

    /**
     * 
     */
    public function resolve(array $params, Request $request) : Response
    {
        $response = $this->resolveMiddlewares($request);

        if ($response instanceof Response)
        {
            return $response;
        }

        return $this->controller->{$this->callback}($request, ...$params);
    }

    /**
     * 
     */
    private function resolveMiddlewares(Request $request) : bool | Response
    {
        foreach ($this->middlewares as $m)
        {
            $m->requestParams($request);
            $response = $m->resolve();
            if ($response === true)
            {
                continue;
            }
            if ($response === false)
            {
                return (new Response())->setStatusCode(400);
            }
            return $response;
        }
        return true;
    }
}