<?php

use Core\App;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function db() : \Core\Lib\DB\DB
{
    return App::db();
}

function session() : \Symfony\Component\HttpFoundation\Session\Session
{
    return App::session();
}

function request() : Request
{
    return App::request();
}

function response(?string $content = '', int $status = 200, array $headers = []) : Response
{
    return (new Response($content, $status, $headers));
}

function json_response(mixed $data = null, int $status = 200, array $headers = [], bool $json = false) : JsonResponse
{
    return (new JsonResponse($data, $status, $headers, $json));
}

function redirect(string $url, int $status = 302, array $headers = []) : RedirectResponse
{
    return (new RedirectResponse($url, $status, $headers));
}

function route(string $name, ...$params) : string
{
    return App::route($name, ...$params);
}

function config(string $key) : mixed
{
    return App::config($key);
}

function __(string $key) : string
{
    return App::translation($key);
}