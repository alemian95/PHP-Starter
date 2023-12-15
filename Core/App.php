<?php

namespace Core;

use Core\Lib\Route\Route;

class App
{

    private static \Symfony\Component\HttpFoundation\Session\Session $session;
    private static \Symfony\Component\HttpFoundation\Request $request;
    private static \Symfony\Component\Filesystem\Filesystem $filesystem;

    private static \Core\Lib\DB\DB $db;

    private static \Jenssegers\Blade\Blade $blade;

    private static array $config;
    private static array $routes;
    private static array $localization;
    private static string $locale;

    /**
     * 
     */
    public static function boot()
    {
        self::$session = new \Symfony\Component\HttpFoundation\Session\Session();
        self::$session->start();

        self::$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        self::$filesystem = new \Symfony\Component\Filesystem\Filesystem();

        self::$db = new \Core\Lib\DB\DB();
        self::$db->connect();

        self::$config['app'] = require __DIR__ . "/../config/app.php";
        self::$config['auth'] = require __DIR__ . "/../config/auth.php";

        self::loadLocalization();
        self::$locale = self::$config['app']['default_locale'];

        self::$routes = require __DIR__ . "/../config/routes.php";

        require_once __DIR__ . "/functions.php";

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
    public static function db() : \Core\Lib\DB\DB
    {
        return self::$db;
    }

    public static function config(string $key)
    {
        $segments = explode('.', $key);
        $config = self::$config;
        foreach ($segments as $s)
        {
            $config = $config[$s] ?? null;
        }
        return $config;
    }

    public static function route(string $name, ...$params) : string
    {
        return App::$routes[$name]->url(...$params);
    }

    public static function translation($key) : string
    {
        $segments = explode('.', $key);
        $value = self::$localization[self::$locale];
        foreach ($segments as $s)
        {
            $value = $value[$s] ?? null;
        }
        return $value ?? $key;
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

    private static function loadLocalization() : void
    {
        foreach (self::$config['app']['locales'] as $locale)
        {
            self::$localization[$locale] = require __DIR__ . "/../lang/$locale.php";
        }
    }

}