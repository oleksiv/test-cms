<?php

namespace App\Transformers;

use App\Entity\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = [

    ];

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return array(
            'id' => $category->getId(),
            'post_title' => $category->getCategoryTitle(),
            'post_content' => $category->getCategoryContent(),
            'post_alias' => $category->getCategoryAlias(),
            'post_image' => $category->getCategoryImage() ? $category->getCategoryImage()->getId() : null,
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        );

    }

}