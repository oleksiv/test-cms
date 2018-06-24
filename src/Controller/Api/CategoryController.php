<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Transformers\CategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Serializers\DataSerializer;
use App\Repository\CategoryRepository;
use League\Fractal\Resource\Collection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller\Api
 * @Route("/api/categories")
 */
class CategoryController extends Controller
{
    /**
     * @Route("", name="categories_index", methods="GET")
     *
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(CategoryRepository $categoryRepository, Request $request)
    {
        $page = $request->get('page', 1) - 1;
        $limit = $request->get('limit', 10);
        $query = $categoryRepository->createQueryBuilder('post')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);
        $categories = new Paginator($query);
        $count = count($categories);
        $manager = new Manager();
        $manager->setSerializer(new DataSerializer());
        $resource = new Collection($categories, new CategoryTransformer());
        return $this->json(array('total_categories' => $count, 'data' => $manager->createData($resource)->toArray()), 200);
    }

    /**
     * @Route("", name="categories_create", methods="POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if ($form->isValid()) {
            // Convert alias if needed
            $category->setAliasBasedOnTitle();
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataSerializer());
            // Prepare data for response
            $resource = new Item($category, new CategoryTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }


    /**
     * @Route("/{id}", name="categories_show", methods="GET")
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        // Serializer manager
        $manager = new Manager();
        $manager->setSerializer(new DataSerializer());
        // Prepare data for response
        $resource = new Item($category, new CategoryTransformer());
        return $this->json($manager->createData($resource)->toArray());
    }

    /**
     * @Route("/{id}", name="categories_update", methods="PUT")
     *
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if ($form->isValid()) {
            // Convert alias if needed
            $category->setAliasBasedOnTitle();
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataSerializer());
            // Prepare data for response
            $resource = new Item($category, new CategoryTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }
}
