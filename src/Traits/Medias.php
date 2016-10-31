<?php

namespace EscapeWork\LaraMedias\Traits;

use EscapeWork\LaraMedias\Collections\MediaCollection;
use EscapeWork\LaraMedias\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait Medias
{
    /**
     * Boot the medias trait for a model.
     *
     * @return void
     */
    public static function bootMedias()
    {
        static::deleting(function($model) {
            $model->removeMedias();
        });
    }

    public function uploadSingleMedia(UploadedFile $media, $field)
    {
        $config  = config('medias.models.' . $this->getTable());
        $dir     = config('medias.dir') . '/' . $this->getTable();
        $uploads = $this->upload()->to($dir)
                                  ->disk(config('medias.disk'))
                                  ->execute($media);

        $medias  = $this->resizeMedias($uploads, $dir);

        if (! is_null($this->{$field})) {
            $this->removeSingleMedia($config, $dir, $field);
        }

        $this->{$field} = $medias->first();
        return $this->{$field};
    }

    public function uploadSingleMediaFromPath($path, $name, $field)
    {
        copy($path, storage_path($name));
        $file = new UploadedFile(storage_path($name), $name, null, null, null, true);

        return $this->uploadSingleMedia($file, $field);
    }

    public function removeSingleMedia($config, $dir, $field)
    {
        $destroyer = $this->mediaDestroyerService();
        $destroyer->removeFromModel($this, $config, $dir, $field);
    }

    public function uploadMultipleMedias($medias)
    {
        if (! $this->areMediasValid($medias)) {
            return;
        }

        $dir     = config('medias.dir') . '/' . config('medias.path');
        $uploads = $this->upload()
                        ->to($dir)
                        ->disk(config('medias.disk'))
                        ->execute($medias);

        $files = $this->resizeMedias($uploads, $dir);
        return $this->mediaService()->to($this)->save($files);
    }

    public function removeMedias($ids = null)
    {
        if ($ids) {
            return $this->detachMedias((array) $ids);
        }

        if ($this->medias && $this->medias->count() > 0) {
            return $this->detachMedias($this->medias->pluck('id')->toArray());
        }
    }

    public function detachMedias($ids = [])
    {
        if (is_null($ids) || count($ids) == 0) {
            return;
        }

        return $this->mediaDestroyerService()
                    ->removeSpecificMedias($ids);
    }

    protected function resizeMedias($files, $dir)
    {
        $files = new MediaCollection($files);
        $files->resize($dir);

        return $files;
    }

    protected function upload()
    {
        return app('EscapeWork\LaravelSteroids\Upload');
    }

    protected function areMediasValid($medias)
    {
        if ($medias instanceof UploadedFile) {
            return true;
        }

        return is_array($medias) && count($medias) > 0 && $medias[0] != null;
    }

    protected function mediaDestroyerService()
    {
        return app('EscapeWork\LaraMedias\Services\MediasDestroyerService');
    }

    protected function mediaService()
    {
        return app('EscapeWork\LaraMedias\Services\MediaService');
    }

    public function addVideo($video)
    {
        return Media::create([
            'model_id'    => $this->id,
            'media_model' => get_class($this),
            'type'        => 'video',
            'file'        => $video,
        ]);
    }
}
