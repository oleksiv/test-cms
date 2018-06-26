<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;

class FeaturedPostsExtension extends AbstractExtension
{
    protected $entityManager;

    /**
     * MenuExtension constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('featuredPosts', array($this, 'featuredPostsRenderer'), array(
                'needs_environment' => true,
                'is_safe' => ['html']
            ))
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @param Category|null $category
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function featuredPostsRenderer(\Twig_Environment $environment, Category $category = null)
    {
        if(empty($category)) {
            return;
        }
        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy(array(
                'id' => $category->getId()
            ));
        // Render menu template
        return $environment->render('featured-posts/index.html.twig', array(
            'category' => $category
        ));
    }

    public function getName()
    {
        return 'FeaturedPostsExtension';
    }
}