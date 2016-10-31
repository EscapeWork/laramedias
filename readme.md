# Laramedias

<p align="center">
[![Latest Stable Version](https://poser.pugx.org/escapework/laramedias/v/stable.png)](https://packagist.org/packages/escapework/laramedias) [![Total Downloads](https://poser.pugx.org/escapework/laramedias/downloads.png)](https://packagist.org/packages/escapework/laramedias)<a href="https://styleci.io/repos/45929157/shield?style=flat"><img src="https://styleci.io/repos/45929157/shield?style=flat" alt="Build Status"></a>

A Laravel package that integrates [Glide](http://glide.thephpleague.com) for easily manage medias on your project.

### Installation

Via Composer:

```
$ composer require escapework/laramedias:"0.4.*"
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

Configurations explained:

```
'disk' => null, // if you dont want to use filesystems.default disk config, change it here...
                // ...for saving on another disk

'max_size' => [
    'width'  => 2000, // when creating medias, the images will be resized to this max_size...
    'height' => 2000, // ...for reducing disk usage
],

'url'  => 'medias',  // if you want to change the laravel glide medias URL
'dir'  => 'medias',  // if you want to change the default directory where the medias are saved
'path' => 'general', // if you want to change the directory where the multipleMedias are saved (you will undestand this later)
```

### Usage

This package allows you to easily use medias with your laravel models. There are two basic ways to use:

### One model has multiple medias

Let's say you have a `Product` model that need to have multiple medias. You have to do this:

* Import the following trait in your model;

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
$product->uploadMultipleMedias($request->file('medias'))`;
```

##### Interate through your medias

The `$product->medias` will be a default Laravel collection of `EscapeWork\LaraMedias\Models\Media` models which you can use any of the collection methods available.

```php
@foreach ($product->medias as $media)
    <?php /* all media models have an presenter class so you can easily show the image in different forms */ ?>
    <img src="{{ $media->present->picture(600, 300, 'crop') }}">
@endforeach
```

Each `$media` object will be a `LaraMedias\Models\Media` eloquent model, which will have a presenter for easily displaying images (see the above example).

The parameters in the example are the [Glide](http://glide.thephpleague.com/) width (`w`), height (`h`) and `fit`. You can see a simple example here (http://glide.thephpleague.com/1.0/simple-example/).

If your model was deleted, all the medias will be deleted too.

##### Deleting medias

For delete your medias, just call the method `removeMedias`.

```php
$product->removeMedias([1, 2]); // just pass the IDs
```

For removing all medias, just call the `removeMedias` method without any parameters.

```php
$product->removeMedias();
```

### One model has one media field

Let's say you have a `Banner` model and want to upload a single image for him. With `Laramedias` you can do this:

First, configure the `config/medias.php` file:

```php
    'models' => [
        'banners' => [
            'model'  => 'App\Models\Banner',
            'fields' => ['banner'] // here you have to put the fields in your model which use medias
        ],
    ],
```

Second, use the `EscapeWork\LaraMedias\Traits\Medias` trait in your `Banner` model.

```php
use EscapeWork\LaraMedias\Traits\Medias;

class Banner extends Model
{

    use Medias;
}
```

Then, you can just use the `uploadSingleMedia` method.

```php
$banner = Banner::find(1);
$banner->uploadSingleMedia($request->file('banner'), 'banner'); // the second parameter is the field name to be updated
$banner->save();
```

After that, you can just use the `media` helper method to show your banner.

```php
<img src="{{ media($banner, 'banner', 1920, 400, 'crop') }}" alt="...">
```

## Contributing

Feel free to open any pull request/issue with your idea/bug/suggestion.

## License

See the [License](https://github.com/EscapeWork/laravel-asset-versioning/blob/master/LICENSE) file.
