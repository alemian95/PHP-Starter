<?php

namespace App\Controllers;

use Core\App;
use Core\Lib\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{

    public function index(Request $r) : Response
    {
        return new Response(App::blade()->make("index")->render());
    }

    public function test(Request $r) : Response
    {
        return new Response(App::blade()->make("test")->render());
    }
}