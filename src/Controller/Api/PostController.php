<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\PostType;
use App\Transformers\PostTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $post->setPostType(Post::TYPE_POST);
        $form = $this->createForm(PostType::class, $post);
        $form->submit($request->request->all());

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->json(array(
                'messages' => array(
                    'Success'
                ),
                'data' => $post
            ));
        }
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
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $resource = new Item($post, new PostTransformer());
        return $this->json($manager->createData($resource)->toArray());
    }
}
