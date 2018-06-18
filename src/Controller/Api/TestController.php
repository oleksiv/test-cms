<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * @Route("/api/test", name="app_api_test")
     */
    public function index()
    {
        return $this->render('api/test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
