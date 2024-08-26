<?php

namespace Database\Seeders;

use App\Entities\ArticleCategory;
use App\Entities\Blogger;
use App\Factories\ArticleCategoryFactory;
use App\Factories\ArticleFactory;
use App\Factories\BloggerFactory;
use App\Factories\SubscriberFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SUBSCRIBER_AMOUNT = 100;
    const ARTICLE_CATEGORY_AMOUNT = 15;
    const BLOGGER_AMOUNT = 20;
    const BLOGGER_ARTICLE_CATEGORY_MAX_AMOUNT = 3;
    const ARTICLE_AMOUNT = 50;

    /** @var SubscriberFactory */
    private $subscriberFactory;

    /** @var ArticleCategoryFactory */
    private $articleCategoryFactory;

    /** @var BloggerFactory */
    private $bloggerFactory;

    /** @var ArticleFactory */
    private $articleFactory;

    public function __construct(SubscriberFactory $subscriberFactory, ArticleCategoryFactory $articleCategoryFactory, BloggerFactory $bloggerFactory, ArticleFactory $articleFactory)
    {
        $this->subscriberFactory = $subscriberFactory;
        $this->articleCategoryFactory = $articleCategoryFactory;
        $this->bloggerFactory = $bloggerFactory;
        $this->articleFactory = $articleFactory;
    }
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->subscriberSeed();
        $articleCategories = $this->articleCategoryFactorySeed();
        $bloggers = $this->bloggerFactorySeed($articleCategories);
        $this->articlesFactorySeed($articleCategories, $bloggers);
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
     * Create seed of Article Categories
     * 
     * @return ArticleCategory[]
     */
    protected function articleCategoryFactorySeed(): array {
        $this->articleCategoryFactory->setUseFlushAfterEachCall(false);

        $return = [];
        for($i=0; $i < self::ARTICLE_CATEGORY_AMOUNT; $i++){
            $title = implode('', fake()->unique()->words());
            $return[] = $this->articleCategoryFactory->create(
                title: $title,
                createdAt:fake()->dateTime()
            );
        }
        
        $this->articleCategoryFactory->flush();
        return $return;
    }

    /**
     * Create seed of Subscribers
     * 
     * @return Blogger[]
     */
    protected function bloggerFactorySeed($articleCategories) {
        $this->bloggerFactory->setUseFlushAfterEachCall(false);
        
        $bloggers = [];
        for($i=0; $i < self::BLOGGER_AMOUNT; $i++){
            $bloggerArticleCategories = $this->getRandomFields($articleCategories, self::BLOGGER_ARTICLE_CATEGORY_MAX_AMOUNT);

            $username = fake()->unique()->userName();
            $bloggers[] = $this->bloggerFactory->create(
                username: $username,
                password: $username, // same as username only to allow easy test login
                createdAt:fake()->dateTime(),
                articleCategories: $bloggerArticleCategories
            );
        }
        
        $this->bloggerFactory->flush();
        return $bloggers;
    }

    /**
     * Create seed of Subscribers
     * 
     * @return void
     */
    protected function articlesFactorySeed($articleCategories, $bloggers) {
        $this->articleFactory->setUseFlushAfterEachCall(false);
        
        for($i=0; $i < self::ARTICLE_AMOUNT; $i++){
            $randomArticleCategories = $this->getRandomFields($articleCategories, 1);
            $randomBloggers = $this->getRandomFields($bloggers, 1);

            $this->articleFactory->create(
                title: fake()->words(3, true),
                abstract: fake()->paragraph(),
                text: fake()->paragraphs(2, true),
                createdAt:fake()->dateTime(),
                articleCategory: $randomArticleCategories[0],
                blogger: $randomBloggers[0]
            );
        }
        
        $this->bloggerFactory->flush();
    }

    protected function getRandomFields($array, $maxCount) {
        $maxRand = rand(1, $maxCount);
        $selectedKeys = array_rand($array, $maxRand);
        if($maxRand === 1){
            $selectedKeys = [$selectedKeys];
        }

        $return = [];
        foreach($selectedKeys AS $selectedKey){
            $return[] = $array[$selectedKey];
        }
        return $return;
    }

}
