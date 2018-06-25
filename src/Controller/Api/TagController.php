<?php

namespace App\Controller\Api;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use App\Serializers\DataSerializer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\TagTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController
 * @package App\Controller\Api
 * @Route("/api/tags")
 */
class TagController extends Controller
{
    /**
     * @Route("", name="tags_index", methods="GET")
     *
     * @param TagRepository $tagRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(TagRepository $tagRepository, Request $request)
    {
        $page = $request->get('page', 1) - 1;
        $limit = $request->get('limit', 10);
        $query = $tagRepository->createQueryBuilder('post')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);
        $tags = new Paginator($query);
        $count = count($tags);
        $manager = new Manager();
        $manager->parseIncludes('image');
        $manager->setSerializer(new DataSerializer());
        $resource = new Collection($tags, new TagTransformer());
        return $this->json(array('total_posts' => $count, 'data' => $manager->createData($resource)->toArray()), 200);
    }

    /**
     * @Route("", name="tags_create", methods="POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $tag = new Tag();
        // Set post type to default TYPE_POST
        $form = $this->createForm(TagType::class, $tag);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if ($form->isValid()) {
            // Convert alias if needed
            $tag->setAliasBasedOnTitle();
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataSerializer());
            // Prepare data for response
            $resource = new Item($tag, new TagTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }


    /**
     * @Route("/{id}", name="tags_show", methods="GET")
     *
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag): Response
    {
        // Serializer manager
        $manager = new Manager();
        $manager->parseIncludes('categories,default_category');
        $manager->setSerializer(new DataSerializer());
        // Prepare data for response
        $resource = new Item($tag, new TagTransformer());
        return $this->json($manager->createData($resource)->toArray());
    }

    /**
     * @Route("/{id}", name="tags_update", methods="PUT")
     *
     * @param Tag $tag
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Tag $tag, Request $request)
    {
        // Set post type to default TYPE_POST
        $form = $this->createForm(TagType::class, $tag);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if ($form->isValid()) {
            // Convert alias if needed
            $tag->setAliasBasedOnTitle();
            // Save to database if valid
            $this->getDoctrine()->getManager()->flush();
            // Transform post data
            $manager = new Manager();
            // Include categories and default_category properties
            $manager->parseIncludes('categories,default_category');
            $manager->setSerializer(new DataSerializer());
            // Prepare data for response
            $resource = new Item($tag, new TagTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 200);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }
}
