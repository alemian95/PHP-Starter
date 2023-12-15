<?php

use Core\App;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

function db() : \Core\Lib\DB\DB
{
    return App::db();
}

function session() : \Symfony\Component\HttpFoundation\Session\Session
{
    return App::session();
}

function request() : \Symfony\Component\HttpFoundation\Request
{
    return App::request();
}

function response(?string $content = '', int $status = 200, array $headers = []) : \Symfony\Component\HttpFoundation\Response
{
    return (new Response($content, $status, $headers))->send();
}

function json_response(mixed $data = null, int $status = 200, array $headers = [], bool $json = false) : \Symfony\Component\HttpFoundation\JsonResponse
{
    return (new JsonResponse($data, $status, $headers, $json))->send();
}

function redirect(string $url, int $status = 302, array $headers = [])
{
    return (new RedirectResponse($url, $status, $headers))->send();
}

function route(string $name, ...$params) : string
{
    return App::route($name, ...$params);
}

function config(string $key)
{
    return App::config($key);
}

function __(string $key)
{
    return App::translation($key);
}