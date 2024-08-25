<?php

namespace App\Factories;

use App\Entities\Article;
use App\Entities\ArticleCategory;
use App\Entities\Blogger;
use DateTime;

class ArticleFactory extends BaseFactory
{
    /**
     * Create a new ArticleCategory entity and persist it.
     *
     * @param string $email
     * @return Article
     */
    public function create(string $title, string $abstract, string $text, Blogger $blogger, ArticleCategory $articleCategory, DateTime $createdAt = null): Article
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setCreated($createdAt ?? new DateTime());

        // Persist the entity
        $this->entityManager->persist($article);
        if ($this->setUseFlushAfterEachCall){
            $this->entityManager->flush();
        }

        return $article;
    }
}
