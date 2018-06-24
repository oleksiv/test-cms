<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Category extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $post = new \App\Entity\Category();
            $post->setCategoryTitle('Category title #' . $i);
            $post->setAliasBasedOnTitle();
            $post->setCategoryContent('Post content #' . $i);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
