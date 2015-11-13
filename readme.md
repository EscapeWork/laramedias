# Laramedias

A Laravel package that integrates [Glide](http://glide.thephpleague.com) for easily manage medias on your project.

### IN DEVELOPMENT

# Laramedias

A Laravel package that integrates [Glide](http://glide.thephpleague.com) for easily manage medias on your project.

### IN DEVELOPMENT

### Installation

Just execute the following code:

```
$ composer require escapework/laramedias
```

### Configuration

Execute the following code:

```
$ php artisan vendor:publish --provider="EscapeWork\LaraMedias\Providers\MediasServiceProvider"
$ php artisan migrate
``

### Usage

This package allows you to easily use medias with your laravel models. There are two basic ways to use:

#### One model has multiple medias

Let's say you have a `Product` model that need to have multiple medias. You have to do this:

* Open `config/medias.php` config file and edit the `medias` key putting your model information;
* Use the following trait in your model;

```php
use EscapeWork\LaraMedias\Traits\Medias;

class Product extends Model
{

    use Medias;
}

Now, you can do this:

##### Upload and create multiple medias:

```php
$product->createMultipleMedias($request->file('medias'))`;
```

##### Interate through your medias

```blade
@foreach ($product->medias as $media)
    <img src="{{ $media->present->picture(600, 300, 'crop') }}">
@endforeach
```
