<?php

namespace App\Http\Controllers;

use App\Entities\Article;
use App\Entities\ArticleCategory;
// use App\Entities\Blogger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $entityManager;

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
            ->select('a')
            ->from(Article::class, 'a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        // Paginate
        $paginator = new Paginator($query, true);
        $totalSubscribers = count($paginator);

        // Transform result to array
        $articles = [];
        foreach ($paginator as $article) {
            $articles[] = $article;
        }

        return response()->json([
            'total' => $totalSubscribers,
            'page' => $page,
            'limit' => $limit,
            'articles' => $articles,
        ]);
    }

    public function store(Request $request)
    {
        // $bloggerAuth = $request->user();

        // if (!$bloggerAuth) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        // $blogger = $this->entityManager->getRepository(Blogger::class)->find($bloggerAuth->getUuid());
        
        $articleCategory = $this->entityManager->getRepository(ArticleCategory::class)->find($request->article_category_id);

        if (!$articleCategory) {
            return response()->json(['message' => __('be.responses.notFound.articleCategory')], 404);
        }

        $article = (new Article())
            ->setTitle($request->title)
            ->setAbstract($request->abstract)
            ->setText($request->text)
            ->setArticleCategory($articleCategory);
            // ->setBlogger($bloggerOrm); TODO
        $article->setCreated(new \DateTime());

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return response()->json($article, 201);
    }

    public function show($id)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            return response()->json(['message' => __('be.responses.notFound.article')], 404);
        }
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            return response()->json(['message' => __('be.responses.notFound.article')], 404);
        } elseif ($article->isDistributed()){
            return response()->json(['message' => __('be.responses.notUpdatable.article')], 405);
        }

        $article
            ->setTitle($request->title)
            ->setAbstract($request->abstract)
            ->setText($request->text);

        if ($request->has('article_category_id')) {
            $articleCategory = $this->entityManager->getRepository(ArticleCategory::class)->find($request->category_id);
            if ($articleCategory) {
                $article->setArticleCategory($articleCategory);
            }
        }

        $this->entityManager->flush();

        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            return response()->json(['message' => __('be.responses.notFound.article')], 404);
        } elseif ($article->isDistributed()){
            return response()->json(['message' => __('be.responses.notDeletable.article')], 405);
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return response()->json(['message' => __('be.responses.success.article.delete')], 204);
    }
}