<?php

namespace App\Controllers;

use Core\Lib\Auth\Auth;
use Core\Lib\Controller\Controller;
use Core\Lib\View\View;
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
}