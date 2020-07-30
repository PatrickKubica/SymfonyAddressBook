<?php

// src/AppBundle/Service/FileUploader.php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;


class FileUploader
{
    private $targetDirectory;
    private $session;

    public function __construct($targetDirectory, Session $session)
    {
        $this->targetDirectory = $targetDirectory;
        $this->session = $session;
    }

    public function upload(UploadedFile $file)
    {

        //In a real application we would scope picture data depending on the currently logged in user
        $fileName = uniqid() . '.' . $file->guessExtension();

        //move the file to the directory where pictures are stored
        try {
            $file->move(
                $this->getTargetDirectory(),
                $fileName
            );
        } catch (FileException $e) {
            $this->session->getFlashBag()->add('error', 'File could not be uploaded');
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
