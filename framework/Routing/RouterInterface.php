<?php

namespace Codex\Framework\Routing;

use Codex\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}