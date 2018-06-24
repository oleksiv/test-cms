<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Post extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 100; $i++) {
            $post = new \App\Entity\Post();
            $post->setPostTitle('Post title #' . $i);
            $post->setAliasBasedOnTitle();
            $post->setPostType(\App\Entity\Post::TYPE_POST);
            $post->setPostContent('Post content #' . $i);
            $post->setPostStatus('draft');
            $manager->persist($post);
        }

        $manager->flush();
    }
}
