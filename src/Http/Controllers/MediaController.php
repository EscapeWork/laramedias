<?php

namespace EscapeWork\LaraMedias\Controllers;

use League\Glide\Server as GlideServer;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function show(GlideServer $server, Request $request)
    {
        return $server->outputImage($request);
    }
}
