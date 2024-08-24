<?php

namespace App\Entities;

use App\EntityRepositories\BloggerRepository;
use App\Utils\UuidGenerator;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass=BloggerRepository::class)
 */
class Blogger extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */    
    private string $username;

    /**
     * @ORM\Column(type="string")
     */    
    private $passwordHash;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function changePassword(string $password): void
    {
        $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getJWTIdentifier()
    {
        return 'uuid';
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     * @ORM\Id
     */
    protected string $uuid;

    /** @ORM\Column(type="datetime") */
    protected DateTime $created;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected DateTime|null $updated = null;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected DateTime|null $removed = null;


    public function getUuid(): string
    {
        return $this->uuid;
    }


    public function getCreated(): DateTime
    {
        return $this->created;
    }


    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }


    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }


    public function setUpdated(?DateTime $updated): void
    {
        $this->updated = $updated;
    }


    public function getRemoved(): ?DateTime
    {
        return $this->removed;
    }


    public function setRemoved(?DateTime $removed): void
    {
        $this->removed = $removed;
    }


    /** @ORM\PrePersist */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->setCreated(now());
    }


    /** @ORM\PreUpdate */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->setUpdated(now());
    }
}