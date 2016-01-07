# Laramedias

[![Latest Stable Version](https://poser.pugx.org/escapework/laramedias/v/stable.png)](https://packagist.org/packages/escapework/laramedias) [![Total Downloads](https://poser.pugx.org/escapework/laramedias/downloads.png)](https://packagist.org/packages/escapework/laramedias)

A Laravel package that integrates [Glide](http://glide.thephpleague.com) for easily manage medias on your project.

### Installation

Via Composer:

```
$ composer require escapework/laramedias:"0.1.*"
```

### Configuration

Add this service provider to your `providers` list:

```php
    EscapeWork\LaraMedias\Providers\MediasServiceProvider::class
```

And execute the following code:

```
$ php artisan vendor:publish --provider="EscapeWork\LaraMedias\Providers\MediasServiceProvider"
$ php artisan migrate
```

### Usage

This package allows you to easily use medias with your laravel models. There are two basic ways to use:

#### One model has multiple medias

Let's say you have a `Product` model that need to have multiple medias. You have to do this:

* Use the following trait in your model;

```php
use EscapeWork\LaraMedias\Traits\Medias;

class Product extends Model
{

    use Medias;
}
```

Now, you can do this:

##### Upload and create multiple medias:

```php
$product->createMultipleMedias($request->file('medias'))`;
```

##### Interate through your medias

The `$product->medias` will be a default Laravel collection of `EscapeWork\LaraMedias\Models\Media` models which you can use any of the collection methods available.

```php
@foreach ($product->medias as $media)
    <?php /* all media models have an presenter class so you can easily show the image in different forms */ ?>
    <img src="{{ $media->present->picture(600, 300, 'crop') }}">
@endforeach
```

Each `$media` object will be a `LaraMedias\Movels\Media` eloquent model, which will have a presenter for easily displaying images (see the above example).

The parameters in the example are the [Glide](http://glide.thephpleague.com/) width (`w`), height (`h`) and `fit`. You can see a simple example here (http://glide.thephpleague.com/1.0/simple-example/).

If your model was deleted, all the medias will be deleted too.
