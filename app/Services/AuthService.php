<?php

namespace App\Services;

use App\Entities\Blogger;
use Doctrine\ORM\EntityManagerInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function login($username, $password)
    {
        $bloggerRepo = $this->entityManager->getRepository(Blogger::class);
        $blogger = $bloggerRepo->findOneBy(['username' => $username]);

        if (!$blogger || !password_verify($password, $blogger->getPasswordHash())) {
            return null;
        }

        return JWTAuth::fromUser($blogger);
    }

    public function me()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh()
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }
}
