<?php

namespace App\Transformers;

use App\Entity\Image;
use App\Entity\Post;
use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'image'
    ];


    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return array(
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'excerpt' => $post->getExcerpt(),
            'alias' => $post->getAlias(),
            'status' => $post->getStatus(),
            'image' => $post->getImage() ? $post->getImage()->getId() : null,
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt(),
        );

    }

    public function includeImage(Post $post)
    {
        if ($post->getImage()) {
            return $this->item($post->getImage(), new ImageTransformer($this->container));
        }
    }

}