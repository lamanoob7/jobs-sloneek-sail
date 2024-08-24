<?php

namespace App\Factories;

use App\Entities\Subscriber;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseFactory
{
    protected EntityManagerInterface $entityManager;

    protected $setUseFlushAfterEachCall = true;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Use flush after each create call
     *
     * @param bool $setUseFlushAfterEachCall
     * @return  self
     */ 
    public function setUseFlushAfterEachCall(bool $setUseFlushAfterEachCall = true)
    {
        $this->setUseFlushAfterEachCall = $setUseFlushAfterEachCall;

        return $this;
    }

    /**
     * Flush entity manager for setting multiple entities
     * and reset setUseFlushAfterEachCall to `true`
     * 
     * @return void
     */
    public function flush() : void {
        $this->entityManager->flush();
        $this->setUseFlushAfterEachCall(true);
    }
}
