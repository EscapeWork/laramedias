<?php

namespace EscapeWork\LaraMedias\Models;

use EscapeWork\LaraMedias\Collections\MediaCollection;
use EscapeWork\LaravelSteroids\Model;
use EscapeWork\LaravelSteroids\PresentableTrait;
use EscapeWork\LaravelSteroids\SortableTrait;

class Media extends Model
{
    /**
     * Table.
     */
    protected $table = 'laramedias';

    /**
     * Fillable fields.
     */
    public $fillable = [
        'id',
        'media_model',
        'model_id',
        'type',
        'file', // pode ser o nome da imagem ou o código do vídeo
        'size',
        'caption',
        'credits',
        'order',
        'active',
        'crop_position',
    ];

    /**
     * Append fields.
     */
    protected $appends = ['full_path'];

    /*
     * Traits
     */
    use PresentableTrait, SortableTrait;

    /**
     * Presenter attribute.
     */
    protected $presenter = 'EscapeWork\LaraMedias\Presenters\MediaPresenter';

    public function scopeActive($query)
    {
        return $query->where('active', '=', true);
    }

    public function scopeGetCurrentModel($query)
    {
        return $query->where('media_model', '=', $this->media_model)
                     ->where('model_id', '=', $this->model_id);
    }

    public function scopeMediaModelFilter($query)
    {
        return $query->where('media_model', '=', $this->media_model);
    }

    public function newCollection(array $models = [])
    {
        return new MediaCollection($models);
    }

    public function delete()
    {
        $file = config('medias.dir').'/'.config('medias.path').'/'.$this->file;

        $destroyer = app('EscapeWork\LaraMedias\Services\MediasDestroyerService');
        $destroyer->removeMedia($file);

        return parent::delete();
    }

    public function mediable()
    {
        return $this->morphTo('mediable', 'media_model', 'model_id');
    }

    public function medias()
    {
        return $this->morphTo();
    }

    public function getFullPathAttribute()
    {
        if (isset($this->attributes['type']) && $this->attributes['type'] === 'video') {
            return $this->present()->picture();
        }

        return asset(config('medias.url').'/'.config('medias.path').'/'.$this->attributes['file']);
    }

    public function isVideo()
    {
        return $this->type == 'video';
    }
}
