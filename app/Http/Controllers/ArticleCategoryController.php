<?php

namespace App\Http\Controllers;

use App\Entities\ArticleCategory;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArticleCategoryController extends Controller
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(Request $request)
    {
        // Pagination Parameters
        $page = max(1, (int) $request->input('page', 1));
        $limit = max(1, (int) $request->input('limit', 10));
        $offset = ($page - 1) * $limit;

        // Create Query
        $query = $this->entityManager->createQueryBuilder()
            ->select('ac')
            ->from(ArticleCategory::class, 'ac')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        // Paginate
        $paginator = new Paginator($query, true);
        $totalArticleCategories = count($paginator);

        // Transform result to array
        $articleCategories = [];
        foreach ($paginator as $articleCategory) {
            $articleCategories[] = [
                'id' => $articleCategory->getUuid(),
                'title' => $articleCategory->getTitle(),
            ];
        }

        return response()->json([
            'total' => $totalArticleCategories,
            'page' => $page,
            'limit' => $limit,
            'articleCategories' => $articleCategories,
        ]);
    }

}