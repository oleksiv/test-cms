<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Class PostController
 * @package App\Controller\Api
 * @Route("/api/posts")
 */
class Controller extends BaseController
{
    protected function getFormErrors(FormInterface $form)
    {
        $errors = array();

        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        /** @var Form $child */
        foreach ($form as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}
