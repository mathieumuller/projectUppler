<?php

namespace AppBundle\Services\FileUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $filename = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $filename);

        return [$filename, $this->getImageOrientation($filename)];
    }

    public function reloadFileFromPath($path)
    {
        return new File($this->targetDir.'/'.$path);
    }

    /**
     * Gets the value of targetDir.
     *
     * @return mixed
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    private function getImageOrientation($filename)
    {
        $imageSize = getimagesize($this->targetDir.'/'.$filename);

        return $imageSize[0] >= $imageSize[1] ? 'landscape' : 'portrait';
    }
}
