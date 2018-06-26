<?php

namespace App\Twig;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;

class MenuExtension extends AbstractExtension
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
            new \Twig_SimpleFunction('menuRenderer', array($this, 'menuRenderer'), array(
                'needs_environment' => true,
                'is_safe' => ['html']
            ))
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function menuRenderer(\Twig_Environment $environment)
    {
        $categories = $this->entityManager->getRepository(Category::class)
            ->createQueryBuilder('category')
            ->where('category.parent IS NULL')
            ->andWhere('category.status = :status')->setParameter(':status', 'published')
            ->getQuery()
            ->getResult();
        // Render menu template
        return $environment->render('menu/index.html.twig', array(
            'categories' => $categories
        ));
    }

    public function getName()
    {
        return 'MenuExtension';
    }
}