<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private $uploadsTrickPath;
    private $uploadsAvatarPath;

    public function __construct(string $uploadsTrickPath, string $uploadsAvatarPath, RequestStackContext $requestStackContext)
    {
        $this->uploadsTrickPath = $uploadsTrickPath;
        $this->uploadsAvatarPath = $uploadsAvatarPath;
        $this->requestStackContext = $requestStackContext;
    }

    public function getPublicTrickPath(string $path): string
    {
        // needed if you deploy under a subdirectory
        return $this->requestStackContext->getBasePath().'/img/trick/'.$path;
    }

    public function getPublicAvatarPath(string $path): string
    {
        // needed if you deploy under a subdirectory
        return $this->requestStackContext->getBasePath().'/img/avatar/'.$path;
    }

    public function uploadTrickImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsTrickPath.'/';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }

    public function uploadAvatar(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsAvatarPath.'/';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }
}
