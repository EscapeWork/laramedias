<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default disk for saving medias
    | Just fill this config if it is diff from filesystem defaults
    |--------------------------------------------------------------------------
    */
    'disk' => null,

    /*
    |--------------------------------------------------------------------------
    | When a picture is uploaded
    | We resize to this max size option here
    |--------------------------------------------------------------------------
    */
    'max_size' => [
        'width'  => 2000,
        'height' => 2000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default multiple medias directory and URL
    |--------------------------------------------------------------------------
    */
    'url'  => 'medias',
    'dir'  => 'medias',
    'path' => 'general',

    /*
    |--------------------------------------------------------------------------
    | Media for use in models which have only one media
    | - Example: A Banner model has a banner image
    |            An User model has an avatar picture
    |            ...
    |--------------------------------------------------------------------------
    */
    'models' => [
        // 'banners' => [
        //     'model'  => 'App\Models\Banner',
        //     'fields' => ['banner'] // here you have to put the fields in your model which use medias
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Glide Server
    |--------------------------------------------------------------------------
    */
    'glide' => [
        'load' => env('LARAMEDIAS_GLIDE_SERVER', true)
    ],
];
