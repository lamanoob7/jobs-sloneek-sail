<?php

namespace App\Factories;

use App\Entities\ArticleCategory;
use DateTime;

class ArticleCategoryFactory extends BaseFactory
{
    /**
     * Create a new ArticleCategory entity and persist it.
     *
     * @param string $email
     * @return ArticleCategory
     */
    public function create(string $title, DateTime $createdAt = null): ArticleCategory
    {
        $ArticleCategory = new ArticleCategory();
        $ArticleCategory->setTitle($title);
        $ArticleCategory->setCreated($createdAt ?? new DateTime());

        // Persist the entity
        $this->entityManager->persist($ArticleCategory);
        if ($this->setUseFlushAfterEachCall){
            $this->entityManager->flush();
        }

        return $ArticleCategory;
    }
}
