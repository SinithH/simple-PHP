<?php

use App\Controller\HomeController;
use App\Controller\PostController;
use Codex\Framework\Http\Response;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [PostController::class, 'show']],
    ['GET', '/name/{name:.+}', function (string $name) {
        return new Response("Hello {$name}");
    }]
];