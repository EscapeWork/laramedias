<?php

return [

    /*
     * When a picture is uploaded
     * We resize to this max size option here
     */
    'max_size' => [
        'width'  => 2000,
        'height' => 2000,
    ],

    /*
     * Default medias directory and mediable models allowed to use medias
     * `models` array indexes are used onto the URL in order to specify
     * the relationship with medias.
     */
    'medias' => [
        'dir'    => storage_path() . '/app/files/medias',
        'url'    => '/media/medias',
        'tables' => [
            // 'news' => [
            //     'model' => 'App\Models\News',
            //     'title' => 'Notícias',
            //     'route' => 'manager.news.index',
            //     'field' => 'title',
            // ],
        ],
    ],

    /*
     * Models which use medias services, eg. users who have to upload their
     * avatars would use a chosen name, that is, 'user', and properties
     * chosen by them. Two main options are 'dir' and 'url'. Eg:
     */
    'models' => [
        // 'users' => [
        //     'model'  => 'App\Models\User',
        //     'dir'    => storage_path() . '/app/medias/users',
        //     'url'    => 'media/users',
        //     'fields' => ['your-picture-field'] // example: banner, avatar, picture, etc
        // ],
    ],

    /*
     * Hidden fields in the medias form. By default, credit field is ommited
     */
    'hidden' => [
        'credits',
        'crop_position',
    ],

];
