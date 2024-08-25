<?php

namespace App\EntityRepositories;

use App\Entities\Article;
use App\Exceptions\SloneekExceptions\SloneekNotFoundException;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

class ArticleRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    /**
     * @param string $uuid
     * @throws \App\Exceptions\SloneekExceptions\SloneekNotFoundException
     * @return \App\Entities\Article
     */
    public function get(string $uuid): Article
    {
        /** @var Article $entity */
        $entity = $this->find($uuid);
        if (!$entity) {
            throw new SloneekNotFoundException(__('be.responses.notFound.articleCategory'));
        }

        return $entity;
    }
}