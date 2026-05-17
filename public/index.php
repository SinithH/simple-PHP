<?php

use Codex\Framework\Http\Kernel;
use Codex\Framework\Http\Request;
use Codex\Framework\Http\Response;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

//$content = '<h2>yo yo</h2>';

//$response = new Response(content: $content, status: 200, headers: []);
$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();