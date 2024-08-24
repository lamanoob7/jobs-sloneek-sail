<?php

namespace App\EntityRepositories;

use App\Entities\ArticleCategory;
use App\Exceptions\SloneekExceptions\SloneekNotFoundException;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

class ArticleCategoryRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    public function get(string $uuid): ArticleCategory
    {
        /** @var ArticleCategory $entity */
        $entity = $this->find($uuid);
        if (!$entity) {
            throw new SloneekNotFoundException(__('be.responses.notFound.articleCategory'));
        }

        return $entity;
    }
}