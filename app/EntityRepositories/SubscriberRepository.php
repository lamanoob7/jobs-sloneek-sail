<?php

namespace App\EntityRepositories;

use App\Entities\Subscriber;
use App\Exceptions\SloneekExceptions\SloneekNotFoundException;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

class SubscriberRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    public function get(string $uuid): Subscriber
    {
        /** @var Subscriber $entity */
        $entity = $this->find($uuid);
        if (!$entity) {
            throw new SloneekNotFoundException(__('be.responses.notFound.subscriber'));
        }

        return $entity;
    }
}