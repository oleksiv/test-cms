<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    const TYPE_POST = 'post';
    const TYPE_ARTICLE = 'article';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=255)
     */
    private $post_title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $post_content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $post_excerpt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post_alias;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="posts")
     */
    private $post_image;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=255)
     */
    private $post_type;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=255)
     */
    private $post_status;

    public function getId()
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->post_title;
    }

    public function setPostTitle(?string $post_title): self
    {
        $this->post_title = $post_title;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(?string $post_content): self
    {
        $this->post_content = $post_content;

        return $this;
    }

    public function getPostExcerpt(): ?string
    {
        return $this->post_excerpt;
    }

    public function setPostExcerpt(?string $post_excerpt): self
    {
        $this->post_excerpt = $post_excerpt;

        return $this;
    }

    public function getPostAlias(): ?string
    {
        return $this->post_alias;
    }

    public function setPostAlias(?string $post_alias): self
    {
        $this->post_alias = $post_alias;

        return $this;
    }

    public function getPostImage()
    {
        return $this->post_image;
    }

    public function setPostImage($post_image)
    {
        $this->post_image = $post_image;

        return $this;
    }

    public function getPostType(): ?string
    {
        return $this->post_type;
    }

    public function setPostType(string $post_type = self::TYPE_POST): self
    {
        $this->post_type = $post_type;

        return $this;
    }

    public function getPostStatus(): ?string
    {
        return $this->post_status;
    }

    public function setPostStatus(string $post_status): self
    {
        $this->post_status = $post_status;

        return $this;
    }

    /**
     * Converts string to alias format
     * @return $this
     */
    public function setAliasBasedOnTitle()
    {
        $value = $this->getPostAlias() ?? $this->getPostTitle();
        // Replace unwanted subsets of characters
        $value = preg_replace('/([^0-9a-zA-Z])+/u', '-', $value);
        // Remove hyphens from right
        $value = preg_replace('/(-)+$/u', '', $value);
        // Remove hyphens from left
        $value = preg_replace('/^(-)+/u', '', $value);
        // Set alias
        $this->setPostAlias($value);
        return $this;
    }
}
