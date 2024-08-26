<?php

namespace App\Entities;

use App\Entities\ArticleCategory;
use App\EntityRepositories\BloggerRepository;
use App\Utils\UuidGenerator;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */    
    private string $username;

    /**
     * @ORM\Column(type="string")
     */    
    private string $passwordHash;

    /**
     * @ORM\ManyToMany(targetEntity="ArticleCategory", mappedBy="bloggers")
     */
    private Collection $articleCategories;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="blogger")
     */
    private Collection $articles;

    public function __construct() {
        $this->articleCategories = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function getArticleCategories(): Collection
    {
        return $this->articleCategories;
    }

    public function addArticleCategory(ArticleCategory $articleCategory): self
    {
        if (!$this->articleCategories->contains($articleCategory)) {
            $this->articleCategories[] = $articleCategory;
            $articleCategory->addBlogger($this);
        }

        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function getJWTIdentifier(): string
    {
        return $this->uuid;
    }

    public function getJWTCustomClaims(): array
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


    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }


    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }


    public function setUpdated(?DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }


    public function getRemoved(): ?DateTime
    {
        return $this->removed;
    }


    public function setRemoved(?DateTime $removed): self
    {
        $this->removed = $removed;
        return $this;
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