<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('excerpt')
            ->add('alias')
            ->add('image', EntityType::class, array(
                'class' => Image::class
            ))
            ->add('categories', EntityType::class, array(
                'class' => Category::class,
                'by_reference' => false,
                'multiple' => true
            ))
            ->add('tags', EntityType::class, array(
                'class' => Tag::class,
                'by_reference' => false,
                'multiple' => true
            ))
            ->add('status')
            ->add('default_category', EntityType::class, array(
                'class' => Category::class,
                'multiple' => false
            ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'csrf_protection' => false,
            'cascade_validation' => true,
        ]);
    }
}
