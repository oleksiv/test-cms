<?php

namespace App\Transformers;

use App\Entity\Image;
use App\Entity\Post;
use App\Entity\Tag;
use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TagTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
    ];

    /**
     * @param Tag $tag
     * @return array
     */
    public function transform(Tag $tag)
    {
        return array(
            'id' => $tag->getId(),
            'title' => $tag->getTitle(),
            'content' => $tag->getContent(),
            'alias' => $tag->getAlias(),
            'status' => $tag->getStatus(),
            'created_at' => $tag->getCreatedAt(),
            'updated_at' => $tag->getUpdatedAt(),
        );

    }

}