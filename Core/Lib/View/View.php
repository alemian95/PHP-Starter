<?php

namespace Core\Lib\View;

use Core\App;
use Symfony\Component\HttpFoundation\Response;

class View
{

    /**
     * 
     */
    public static function make(string $name, array $data = [])
    {
        return new Response(App::blade()->make($name, $data)->render());
    }
}