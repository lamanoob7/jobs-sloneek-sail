<?php

namespace App\Entities;

use App\EntityRepositories\SubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriberRepository::class)
 */
class Subscriber extends BaseEntity
{
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $email;

    /**
     * Get the value of email
     */ 
    public function getEmail() : ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}