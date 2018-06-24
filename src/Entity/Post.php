<?php

namespace App\Entity;

use App\Contracts\AliasInterface;
use App\Helpers\StringHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"post_alias"},
 *     errorPath="post_alias",
 *     message="This alias is already in use."
 * )
 */
class Post implements AliasInterface
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $post_alias;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     * @return Post
     */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return Post
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime();
        return $this;
    }

    public function getId()
    {
        return $this->id;
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

    /**
     * @return null|Image
     */
    public function getPostImage()
    {
        return $this->post_image;
    }

    public function setPostImage($post_image)
    {
        $this->post_image = $post_image;

        return $this;
    }

    public function getPostType()
    {
        return $this->post_type;
    }

    public function setPostType($post_type = self::TYPE_POST)
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
        $this->setPostAlias(StringHelper::hyphenCase($value));
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

    public function getPostTitle(): ?string
    {
        return $this->post_title;
    }

    public function setPostTitle(?string $post_title): self
    {
        $this->post_title = $post_title;

        return $this;
    }
}
