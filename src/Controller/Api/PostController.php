<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\PostType;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Transformers\PostTransformer;
use Symfony\Component\CssSelector\Parser\Handler\StringHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\Fractal\Serializer\DataArraySerializer;

/**
 * Class PostController
 * @package App\Controller\Api
 * @Route("/api/posts")
 */
class PostController extends Controller
{
    /**
     * @Route("", name="posts_create", methods="POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $post = new Post();
        // Set post type to default TYPE_POST
        $post->setPostType(Post::TYPE_POST);
        $form = $this->createForm(PostType::class, $post);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if($form->isValid()) {
            // Convert alias if needed
            $post->setAliasBasedOnTitle();
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataArraySerializer());
            // Prepare data for response
            $resource = new Item($post, new PostTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }


    /**
     * @Route("/{id}", name="posts_show", methods="GET")
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        // Serializer manager
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        // Prepare data for response
        $resource = new Item($post, new PostTransformer());
        return $this->json($manager->createData($resource)->toArray());
    }

    /**
     * @Route("/{id}", name="posts_update", methods="PUT")
     *
     * @param Post $post
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Post $post, Request $request)
    {
        // Set post type to default TYPE_POST
        $post->setPostType(Post::TYPE_POST);
        $form = $this->createForm(PostType::class, $post);
        // Fill the form with submitted data
        $form->submit($request->request->all());
        // Validate form
        if($form->isValid()) {

            // Convert alias if needed
            $post->setAliasBasedOnTitle();
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataArraySerializer());
            // Prepare data for response
            $resource = new Item($post, new PostTransformer());
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }
}
