<?php

namespace App\Controller\Api;

use App\Entity\Image;
use App\Form\ImageType;
use App\Transformers\ImageTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Api\Controller as BaseController;

/**
 * Class ImagesController
 * @package App\Controller\Api
 * @Route("/api/images")
 */
class ImagesController extends BaseController
{
    /**
     * @Route("", name="images_create", methods="POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $image = new Image();
        // Set post type to default TYPE_POST
        $form = $this->createForm(ImageType::class, $image);
        // Fill the form with submitted data
        $form->submit($request->files->all());
        // Validate form
        if ($form->isValid()) {
            /** @var UploadedFile $file */
            $file = $image->getImagePath();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            // Set image path
            $image->setImagePath($fileName);
            // Save to database if valid
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            // Transform post data
            $manager = new Manager();
            $manager->setSerializer(new DataArraySerializer());
            // Prepare data for response
            $resource = new Item($image, new ImageTransformer($this->container));
            // Status code 201 Created
            return $this->json($manager->createData($resource)->toArray(), 201);
        }
        // Return form errors
        return $this->json(array(
            'messages' => $this->getFormErrors($form)
        ), 400);
    }
}
