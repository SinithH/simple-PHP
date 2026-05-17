<?php

namespace App\Controller;
use Codex\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = '<h2> Hello World! </h2>';

        return new Response($content);
    }
}