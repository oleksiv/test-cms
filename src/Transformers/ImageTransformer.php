<?php

namespace App\Transformers;

use App\Entity\Image;
use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageTransformer extends TransformerAbstract
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param Image $image
     * @return array
     */
    public function transform(Image $image)
    {
        return array(
            'id' => $image->getId(),
            'image_path' => '/' . $this->container->getParameter('images_directory') . '/' . $image->getImagePath(),
        );
    }

}