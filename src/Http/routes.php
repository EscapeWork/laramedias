<?php
/*
|------------------------------------------------------------------------------
| escapework/laramedias routes
|------------------------------------------------------------------------------
*/

Route::get('media/{path}', [
    'as'   => 'manager.media.show',
    'uses' => '',
])->where('path', '.+');
