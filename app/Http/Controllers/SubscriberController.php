<?php

namespace App\Http\Controllers;

use App\Entities\Subscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Illuminate\Http\Request;

class SubscriberController extends Controller
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
            ->select('s')
            ->from(Subscriber::class, 's')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        // Paginate
        $paginator = new Paginator($query, true);
        $totalSubscribers = count($paginator);

        // Transform result to array
        $subscribers = [];
        foreach ($paginator as $subscriber) {
            $subscribers[] = [
                'id' => $subscriber->getUuid(),
                'email' => $subscriber->getEmail(),
            ];
        }

        return response()->json([
            'total' => $totalSubscribers,
            'page' => $page,
            'limit' => $limit,
            'subscribers' => $subscribers,
        ]);
    }
}