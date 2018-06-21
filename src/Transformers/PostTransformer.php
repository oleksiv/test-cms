<?php

namespace App\Transformers;

use App\Entity\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract {

    /**
     * @var array
     */
    protected $availableIncludes = [];

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
            'post_image' => $post->getPostImage(),
            'post_status' => $post->getPostStatus(),
        );
    }

}