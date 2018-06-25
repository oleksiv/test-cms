<?php

namespace App\Transformers;

use App\Entity\Image;
use App\Entity\Post;
use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'image',
        'categories',
        'default_category',
        'tags',
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

    public function includeCategories(Post $post)
    {
        if ($post->getCategories()) {
            return $this->collection($post->getCategories(), new CategoryTransformer());
        }
    }

    public function includeDefaultCategory(Post $post)
    {
        if ($post->getDefaultCategory()) {
            return $this->item($post->getDefaultCategory(), new CategoryTransformer());
        }
    }

    public function includeTags(Post $post)
    {
        if ($post->getTags()) {
            return $this->collection($post->getTags(), new TagTransformer());
        }
    }

}