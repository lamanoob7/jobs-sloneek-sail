<?php

namespace Database\Seeders;

use App\Factories\SubscriberFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SUBSCRIBER_AMOUNT = 100;

    /** @var SubscriberFactory */
    private $subscriberFactory;

    public function __construct(SubscriberFactory $subscriberFactory)
    {
        $this->subscriberFactory = $subscriberFactory;
    }
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->subscriberSeed();
    }

    /**
     * Create seed of Subscribers
     * 
     * @return void
     */
    protected function subscriberSeed() {
        $this->subscriberFactory->setUseFlushAfterEachCall(false);

        for($i=0; $i < self::SUBSCRIBER_AMOUNT; $i++){
            $this->subscriberFactory->create(
                email: fake()->unique()->safeEmail(),
                createdAt:fake()->dateTime()
            );
        }
        
        $this->subscriberFactory->flush();
    }

}
