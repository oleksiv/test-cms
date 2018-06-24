<?php

namespace App\Transformers;

use App\Entity\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'children'
    ];

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return array(
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'content' => $category->getContent(),
            'alias' => $category->getAlias(),
            'image' => $category->getImage() ? $category->getImage()->getId() : null,
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        );

    }

    public function includeChildren(Category $category) {
        return $this->collection($category->getChildren(), new CategoryTransformer());
    }

}