<?php

namespace App\Entity;

use App\Contracts\AliasInterface;
use App\Helpers\StringHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"category_alias"},
 *     errorPath="category_alias",
 *     message="This alias is already in use."
 * )
 */
class Category implements AliasInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category_title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $category_content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category_alias;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     */
    private $category_image;

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
     * @return Category
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
     * @return Category
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

    public function getCategoryTitle(): ?string
    {
        return $this->category_title;
    }

    public function setCategoryTitle($category_title)
    {
        $this->category_title = $category_title;

        return $this;
    }

    public function getCategoryContent(): ?string
    {
        return $this->category_content;
    }

    public function setCategoryContent(?string $category_content): self
    {
        $this->category_content = $category_content;

        return $this;
    }

    public function getCategoryAlias(): ?string
    {
        return $this->category_alias;
    }

    public function setCategoryAlias(string $category_alias): self
    {
        $this->category_alias = $category_alias;

        return $this;
    }

    /**
     * @return Image
     */
    public function getCategoryImage()
    {
        return $this->category_image;
    }

    public function setCategoryImage(?string $category_image): self
    {
        $this->category_image = $category_image;

        return $this;
    }

    public function setAliasBasedOnTitle()
    {
        $value = $this->getCategoryAlias() ?? $this->getCategoryTitle();
        $this->setCategoryAlias(StringHelper::hyphenCase($value));
        return $this;
    }
}
