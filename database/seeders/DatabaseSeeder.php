<?php

namespace Database\Seeders;

use App\Factories\ArticleCategoryFactory;
use App\Factories\SubscriberFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SUBSCRIBER_AMOUNT = 100;
    const ARTICLE_CATEGORY_AMOUNT = 15;

    /** @var SubscriberFactory */
    private $subscriberFactory;

    /** @var ArticleCategoryFactory */
    private $articleCategoryFactory;

    public function __construct(SubscriberFactory $subscriberFactory, ArticleCategoryFactory $articleCategoryFactory)
    {
        $this->subscriberFactory = $subscriberFactory;
        $this->articleCategoryFactory = $articleCategoryFactory;
    }
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->subscriberSeed();
        $this->articleCategoryFactorySeed();
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

    /**
     * Create seed of Subscribers
     * 
     * @return void
     */
    protected function articleCategoryFactorySeed() {
        $this->articleCategoryFactory->setUseFlushAfterEachCall(false);

        for($i=0; $i < self::ARTICLE_CATEGORY_AMOUNT; $i++){
            $this->articleCategoryFactory->create(
                title: fake()->unique()->word(),
                createdAt:fake()->dateTime()
            );
        }
        
        $this->articleCategoryFactory->flush();
    }

}
