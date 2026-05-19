<?php

namespace App\Controller;

use Codex\Framework\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        $content = "This is the post $id";

        return new Response($content);
    }
}