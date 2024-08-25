<?php

namespace App\Entities;

use App\Entities\Blogger;
use App\EntityRepositories\ArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=ArticleCategoryRepository::class)
 */
class Article extends BaseEntity implements JsonSerializable
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=500)
     * @var string
     */
    private string $abstract;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity="ArticleCategory", inversedBy="articles")
     * @ORM\JoinColumn(name="article_category_id", referencedColumnName="uuid")
     * @var ArticleCategory
     */
    private ArticleCategory $articleCategory;

    /**
     * @ORM\ManyToOne(targetEntity="Blogger", inversedBy="articles")
     * @ORM\JoinColumn(name="blogger_uuid", referencedColumnName="uuid")
     * @var Blogger
     */
    private Blogger $blogger;

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of abstract
     *
     * @return  string
     */ 
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set the value of abstract
     *
     * @param  string  $abstract
     *
     * @return  self
     */ 
    public function setAbstract(string $abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get the value of text
     *
     * @return  string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @param  string  $text
     *
     * @return  self
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of articleCategory
     *
     * @return  ArticleCategory
     */ 
    public function getArticleCategory()
    {
        return $this->articleCategory;
    }

    /**
     * Set the value of articleCategory
     *
     * @param  ArticleCategory  $articleCategory
     *
     * @return  self
     */ 
    public function setArticleCategory(ArticleCategory $articleCategory)
    {
        $this->articleCategory = $articleCategory;

        return $this;
    }

    /**
     * Get the value of blogger
     *
     * @return  Blogger
     */ 
    public function getBlogger()
    {
        return $this->blogger;
    }

    /**
     * Set the value of blogger
     *
     * @param  Blogger  $blogger
     *
     * @return  self
     */ 
    public function setBlogger(Blogger $blogger)
    {
        $this->blogger = $blogger;

        return $this;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getUuid(),
            'title' => $this->getTitle(),
            'abstract' => $this->getAbstract(),
            'text' => $this->getText(),
            'articleCategory' => $this->getArticleCategory()
        ];
    }
}