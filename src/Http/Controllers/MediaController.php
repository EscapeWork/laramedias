<?php

namespace EscapeWork\LaraMedias\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use League\Glide\Server as GlideServer;

class MediaController extends Controller
{
    public function show(GlideServer $server, Request $request)
    {
        return $server->outputImage(strtok($request->server->get('REQUEST_URI'), '?'), $request->all());
    }
}
