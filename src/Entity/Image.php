<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={"image/*"})
     */
    private $image_path;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="post_image")
     */
    private $posts;

    public function getId()
    {
        return $this->id;
    }

    public function getImagePath()
    {
        return $this->image_path;
    }

    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;

        return $this;
    }
}
