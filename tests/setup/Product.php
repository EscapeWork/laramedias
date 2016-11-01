<?php

use EscapeWork\LaraMedias\Traits\Medias;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Table.
     */
    protected $table = 'products';

    /**
     * Fillable fields.
     */
    protected $fillable = [
        'title',
    ];

    use Medias;
}
