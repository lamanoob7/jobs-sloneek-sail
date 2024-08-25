<?php

namespace App\Entities;

use App\Entities\Blogger;
use App\EntityRepositories\ArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleCategoryRepository::class)
 */
class ArticleCategory extends BaseEntity
{
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $title;

    /**
     * @ORM\ManyToMany(targetEntity="Blogger", inversedBy="articleCategories")
     * @ORM\JoinTable(name="bloggers_article_categories",
     * joinColumns={@ORM\JoinColumn(name="article_categories_id", referencedColumnName="uuid")},
     * inverseJoinColumns={@ORM\JoinColumn(name="blogger_id", referencedColumnName="uuid")})
     */
    private Collection $bloggers;

    public function __construct() {
        $this->bloggers = new ArrayCollection();
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Blogger[]
     */
    public function getBloggers(): ArrayCollection
    {
        return $this->bloggers;
    }

    public function addBlogger(Blogger $blogger): self
    {
        if (!$this->bloggers->contains($blogger)) {
            $this->bloggers[] = $blogger;
            $blogger->addArticleCategory($this);
        }

        return $this;
    }
}