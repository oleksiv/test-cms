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
            $post->setTitle('Post title #' . $i);
            $post->setAliasBasedOnTitle();
            $post->setType(\App\Entity\Post::TYPE_POST);
            $post->setContent('Post content #' . $i);
            $post->setStatus('draft');
            $manager->persist($post);
        }

        $manager->flush();
    }
}
