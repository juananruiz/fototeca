<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * @var
     */
    private $uploadDirectory;

    /**
     * FileUploader constructor.
     * @param $uploadDirectory
     */
    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    /**
     * Borra el fichero anterior si existe y pasa el nuevo a $this->upload
     * @param $containerId
     * @param $currentFileName
     * @param UploadedFile $file
     * @return string
     */
    public function update($containerId, $currentFileName, UploadedFile $file)
    {
        $containerDirectory = $this->uploadDirectory . $containerId . '/';
        $currentFilePath = $containerDirectory . $currentFileName();
        if (is_file($currentFilePath)) {
            unlink($currentFilePath);
        }

        return $this->upload($containerId, $file);
    }

    /**
     * @param integer $containerId
     * @param UploadedFile $file
     * @return string
     */
    public function upload($containerId, UploadedFile $file)
    {
        $containerDirectory = $this->uploadDirectory . '/' . $containerId;
        // Crea el directorio de destino si no existe
        if (!is_file($containerDirectory) && !is_dir($containerDirectory)) {
            mkdir($containerDirectory);
            chmod($containerDirectory, 0755);
        }
        /** @var UploadedFile $file */
        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($containerDirectory, $fileName);

        return $fileName;
    }

    /**
     * @param int $containerId
     * @param string $fileName
     */
    public function remove($containerId, $fileName)
    {
        $filePath = $this->uploadDirectory . '/' . $containerId . '/' . $fileName;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}

