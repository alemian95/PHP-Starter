<?php

namespace App\Controllers;

use Core\Lib\Controller\Controller;
use Core\Lib\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{

    public function index(Request $r) : Response
    {
        dump(__('general.test'));
        return View::make('index');
    }

    public function test(Request $r) : Response
    {
        return View::make('test');
    }

    public function api(Request $r) : JsonResponse
    {
        return new JsonResponse($r);
    }
}