<?php

namespace App\Policies;

use App\Entities\Blogger;
use App\Entities\Article;
use App\Entities\ArticleCategory;

class ArticlePolicy
{
    /**
     * Determine if the given blogger can create an article in the specified category.
     *
     * @param  \App\Entities\Blogger  $blogger
     * @param  \App\Entities\ArticleCategory  $category
     * @return bool
     */
    public function create(Blogger $blogger, ArticleCategory $articleCategory)
    {
        // Check if the blogger has the category assigned
        return $blogger->getArticleCategories()->contains($articleCategory);
    }

    /**
     * Determine if the given blogger can update the given article.
     *
     * @param  \App\Entities\Blogger  $blogger
     * @param  \App\Entities\Article  $article
     * @return bool
     */
    public function update(Blogger $blogger, Article $article)
    {
        // Check if the blogger is the owner of the article
        return $article->getBlogger()->getUuid() === $blogger->getUuid();
    }

    /**
     * Determine if the given blogger can delete the given article.
     *
     * @param  \App\Entities\Blogger  $blogger
     * @param  \App\Entities\Article  $article
     * @return bool
     */
    public function delete(Blogger $blogger, Article $article)
    {
        // Check if the blogger is the owner of the article
        return $article->getBlogger()->getUuid() === $blogger->getUuid();
    }
}
