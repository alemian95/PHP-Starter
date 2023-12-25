<?php

namespace App\Controllers;

use Core\Lib\Auth\Auth;
use Core\Lib\Controller\Controller;
use Core\Lib\View\View;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{

    public function index(Request $r) : Response
    {
        return View::make('index');
    }

    public function test(Request $r) : Response
    {
        return View::make('test');
    }

    public function login(Request $r) : Response
    {
        $result = Auth::attempt("admin@example.com", "password");
        dump($result);

        return response();
    }

    public function api(Request $r) : JsonResponse
    {
        return json_response($_SERVER);
    }

    public function jwt(Request $r) : Response
    {
        $key = env('JWT_SECRET');
        $payload = [
            'iss' => env('APP_URL'),
            'iat' => time(),
            'exp' => time() + 7200
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');

        return response($jwt);
    }
}