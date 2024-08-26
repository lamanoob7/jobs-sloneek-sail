<?php

namespace App\Factories;

use App\Entities\Subscriber;
use DateTime;

class SubscriberFactory extends BaseFactory
{
    /**
     * Create a new Subscriber entity and persist it.
     *
     * @param string $email
     * @return Subscriber
     */
    public function create(string $email, DateTime $createdAt = null): Subscriber
    {
        $subscriber = new Subscriber();
        $subscriber->setEmail($email);
        $subscriber->setCreated($createdAt ?? new DateTime());

        // Persist the entity
        $this->entityManager->persist($subscriber);
        if ($this->setUseFlushAfterEachCall){
            $this->entityManager->flush();
        }

        return $subscriber;
    }
}
