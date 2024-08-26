<?php

namespace App\Factories;

use App\Entities\ArticleCategory;
use App\Entities\Blogger;
use DateTime;

class BloggerFactory extends BaseFactory
{
    /**
     * Create a new Blogger entity and persist it.
     *
     * @param string $username
     * @param string $password
     * @param DateTime $createdAt
     * @param ArticleCategory[] $articleCategories
     * @return Blogger
     */
    public function create(string $username, string $password, DateTime $createdAt = null, $articleCategories = []): Blogger
    {
        $blogger = (new Blogger())
            ->setUsername($username)
            ->setPassword($password)
            ->setCreated($createdAt ?? new DateTime());

        foreach($articleCategories AS $articleCategory){
            $blogger->addArticleCategory($articleCategory);
        }

        // Persist the entity
        $this->entityManager->persist($blogger);
        if ($this->setUseFlushAfterEachCall){
            $this->entityManager->flush();
        }

        return $blogger;
    }
}
