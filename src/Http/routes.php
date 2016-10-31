<?php
/*
|------------------------------------------------------------------------------
| escapework/laramedias routes
|------------------------------------------------------------------------------
*/

Route::get(config('medias.url').'/{path}', [
    'as'   => 'manager.media.show',
    'uses' => 'MediaController@show',
])->where('path', '.+');
