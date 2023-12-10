<?php

namespace Core;

class App
{

    private static \Symfony\Component\HttpFoundation\Session\Session $session;
    private static \Symfony\Component\HttpFoundation\Request $request;
    private static \Symfony\Component\Filesystem\Filesystem $filesystem;

    private static \Jenssegers\Blade\Blade $blade;

    private static array $config;
    private static array $routes;

    /**
     * 
     */
    public static function boot()
    {
        self::$session = new \Symfony\Component\HttpFoundation\Session\Session();
        self::$session->start();

        self::$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        self::$filesystem = new \Symfony\Component\Filesystem\Filesystem();

        self::$config['app'] = require __DIR__ . "/../config/app.php";
        self::$config['auth'] = require __DIR__ . "/../config/auth.php";

        self::$routes = require __DIR__ . "/../config/routes.php";

        $response = self::resolveRequest();
        
        return $response ? $response->send() : (new \Symfony\Component\HttpFoundation\Response())->setStatusCode(404)->send();
    }

    /**
     * 
     */
    public static function session() : \Symfony\Component\HttpFoundation\Session\Session
    {
        return self::$session;
    }

    /**
     * 
     */
    public static function request() : \Symfony\Component\HttpFoundation\Request
    {
        return self::$request;
    }

    /**
     * 
     */
    public static function filesystem() : \Symfony\Component\Filesystem\Filesystem
    {
        return self::$filesystem;
    }

    /**
     * 
     */
    public static function blade() : \Jenssegers\Blade\Blade
    {
        return self::$blade;
    }

    /**
     * 
     */
    private static function resolveRequest() : \Symfony\Component\HttpFoundation\Response | null
    {
        $uri = "/" . implode("/", array_diff(
            explode("/", self::request()->getRequestUri()),
            explode("/", env("APP_URL"))
        ));

        $method = self::request()->getMethod();

        foreach (static::$routes as $route)
        {
            if (preg_match($route->regex(), $uri, $matches))
            {

                if ($route->method() !== $method)
                {
                    return (new \Symfony\Component\HttpFoundation\Response())->setStatusCode(405)->send();
                }

                self::$blade = new \Jenssegers\Blade\Blade(__DIR__ . "/../resources/views", __DIR__ . "/../storage/cache/views");

                array_shift($matches);
                return $route->resolve($matches, static::$request);
            }
        }

        return null;
    }

}