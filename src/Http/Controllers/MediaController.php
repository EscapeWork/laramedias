<?php

namespace EscapeWork\LaraMedias\Http\Controllers;

use League\Glide\Server as GlideServer;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function show($path, GlideServer $server, Request $request)
    {
        return $server->outputImage($path, $request);
    }
}
