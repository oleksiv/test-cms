<?php

namespace App\Transformers;

use App\Entity\Image;
use App\Entity\Post;
use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'post_image'
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
            'post_title' => $post->getPostTitle(),
            'post_content' => $post->getPostContent(),
            'post_excerpt' => $post->getPostExcerpt(),
            'post_alias' => $post->getPostAlias(),
            'post_status' => $post->getPostStatus(),
            'post_image' => $post->getPostImage() ? $post->getPostImage()->getId() : null,
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt(),
        );

    }

    public function includePostImage(Post $post)
    {
        if ($post->getPostImage()) {
            return $this->item($post->getPostImage(), new ImageTransformer($this->container));
        }
    }

}