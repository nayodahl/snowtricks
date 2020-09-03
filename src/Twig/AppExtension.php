<?php

namespace App\Twig;

use App\Service\UploaderHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploaded_trick', [$this, 'getUploadedTrickPath']),
            new TwigFunction('uploaded_avatar', [$this, 'getUploadedAvatarPath']),
        ];
    }

    public function getUploadedTrickPath(string $path): string
    {
        return $this->container
        ->get(UploaderHelper::class)
        ->getPublicTrickPath($path);
    }

    public function getUploadedAvatarPath(string $path): string
    {
        return $this->container
        ->get(UploaderHelper::class)
        ->getPublicAvatarPath($path);
    }

    public static function getSubscribedServices()
    {
        return [
            UploaderHelper::class,
        ];
    }
}
