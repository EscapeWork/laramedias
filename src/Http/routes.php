<?php
/*
|------------------------------------------------------------------------------
| escapework/laramedias routes
|------------------------------------------------------------------------------
*/

Route::get('medias/{path}', [
    'as'   => 'manager.media.show',
    'uses' => 'MediaController@show',
])->where('path', '.+');
