<?php

namespace App\Transformers;

use App\Entity\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'children',
        'parent',
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
            'status' => $category->getStatus(),
            'alias' => $category->getAlias(),
            'image' => $category->getImage() ? $category->getImage()->getId() : null,
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        );

    }

    public function includeChildren(Category $category)
    {
        return $this->collection($category->getChildren(), new CategoryTransformer());
    }

    public function includeParent(Category $category)
    {
        if ($category->getParent()) {
            return $this->item($category->getParent(), new CategoryTransformer());
        }
    }

}