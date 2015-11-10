<?php

namespace EscapeWork\LaraMedias\Traits;

use EscapeWork\LaraMedias\Collections\MediaCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait Medias
{

    protected $media;

    public function createMultipleMedias($medias)
    {
        if (! $this->areMediasValid($medias)) {
            return;
        }

        $dir     = config('medias.medias.dir');
        $uploads = $this->upload()->to($dir)->execute($medias);
        $files   = $this->resizeMedias($uploads, $dir);

        return $this->mediaService()->to($this)->save($files);
    }

    public function removeSingleMedia($config, $field)
    {
        $destroyer = $this->mediaDestroyerService();

        $destroyer->removeFromModel($this, $config, 'avatar');
    }

    public function storeSingleMedia(UploadedFile $media, $config, $field)
    {
        $config  = config('medias.models.' . $config);
        $dir     = $config['dir'];
        $uploads = $this->upload()->to($dir)->execute($media);
        $medias  = $this->resizeMedias($uploads, $dir);

        if (! is_null($this->{$field})) {
            $this->removeSingleMedia($config, $field);
        }

        $this->{$field} = $medias->first();
        return $this->{$field};
    }

    public function detachMedias($ids = [])
    {
        if (is_null($ids) || count($ids) == 0) {
            return;
        }

        $destroyer = $this->mediaDestroyerService();

        return $destroyer->removeSpecificMedias($ids);
    }

    protected function resizeMedias($files, $dir)
    {
        $files = new MediaCollection($files);
        $files->resize($dir);

        return $files;
    }

    protected function upload()
    {
        return app('EscapeWork\LaravelUploader\Upload');
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

}
