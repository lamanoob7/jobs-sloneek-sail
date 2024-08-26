<?php

namespace App\Jobs;

use App\Entities\Article;
use App\Entities\Subscriber;
use App\Mail\ArticlesNotification;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendArticlesToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entityManager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all articles that have not been distributed
        $articles = $this->entityManager->getRepository(Article::class)->findBy(['distributed' => null]);

        if (count($articles) === 0) {
            return;
        }

        // Get all subscribers
        $subscribers = $this->entityManager->getRepository(Subscriber::class)->findAll();

        foreach ($subscribers as $subscriber) {
            // Send mock email
            Mail::to($subscriber->getEmail())
                    ->send(new ArticlesNotification($articles));
        }

        $now = new \DateTime();
        // Mark articles as distributed
        foreach ($articles as $article) {
            $article->setDistributed($now);
        }

        // Persist the changes to the database
        $this->entityManager->flush();
    }
}
