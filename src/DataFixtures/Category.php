<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class Category extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array(
            'World',
            'U.S',
            'Technology',
            'Design',
            'Culture',
            'Business',
            'Politics',
            'Opinion',
            'Science',
            'Health',
            'Style',
            'Travel',
        );
        $faker = Factory::create();

        // Create image
        $image = new Image();
        $image->setImagePath('0df9ad589d4f5ce5ab3c23b7b287e4cf.jpeg');
        $manager->persist($image);
        $manager->flush();
        // Create categories
        foreach ($categories as $value) {
            $category = new \App\Entity\Category();
            $category->setTitle($value);
            $category->setStatus('published');
            $category->setAliasBasedOnTitle();
            $category->setContent($faker->paragraph(rand(2, 10)));
            $category->setImage($image);
            $manager->persist($category);
            $manager->flush();

            // Create posts
            for ($i = 0; $i < rand(2, 15); $i++) {
                $post = new \App\Entity\Post();
                $post->setTitle($faker->sentence());
                $post->setAliasBasedOnTitle();
                $post->setType(\App\Entity\Post::TYPE_POST);
                $post->setExcerpt($faker->paragraph(rand(3, 5)));
                $post->setContent($faker->paragraph(rand(20, 40)));
                $post->setStatus('draft');
                $post->setDefaultCategory($category);
                $category->setImage($image);
                $post->addCategory($category);
                $manager->persist($post);
            }

            $manager->flush();
        }


        // Save categories
    }
}
