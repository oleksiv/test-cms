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
            $post->setTitle('Category title #' . $i);
            $post->setAliasBasedOnTitle();
            $post->setContent('Post content #' . $i);
            $manager->persist($post);
        }

        $manager->flush();

        // Fetch all categories
        $categories = $manager->getRepository(\App\Entity\Category::class)->findAll();
        foreach ($categories as $category) {
            // Create child categories
            $post = new \App\Entity\Category();
            $post->setTitle('Category child for #' . $category->getId());
            $post->setAliasBasedOnTitle();
            $post->setContent('Category child for #' . $category->getId());
            $post->setParent($category);
            $manager->persist($post);
        }

        // Save categories
        $manager->flush();
    }
}
