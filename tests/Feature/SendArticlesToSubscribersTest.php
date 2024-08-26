<?php

namespace Tests\Feature;

use App\Jobs\SendArticlesToSubscribers;
use App\Entities\Article;
use App\Entities\Subscriber;
use App\Mail\ArticlesNotification;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\SentMessage;
use Tests\TestCase;

class SendArticlesToSubscribersTest extends TestCase
{
    use RefreshDatabase;

    public function testJobSetsDistributedAsDateTime()
    {
        // Mock the EntityManager
        $entityManager = $this->createMock(EntityManagerInterface::class);

        // Mock the repositories and entities
        $articleRepo = $this->createMock(\Doctrine\ORM\EntityRepository::class);
        $subscriberRepo = $this->createMock(\Doctrine\ORM\EntityRepository::class);
        
        // Mocking articles
        $article = $this->createMock(Article::class);
        $article->expects($this->once())->method('setDistributed')
            ->with($this->isInstanceOf(\DateTime::class));

        // Mocking subscribers
        $subscriber = $this->createMock(Subscriber::class);
        $subscriber->expects($this->exactly(2))->method('getEmail')->willReturn('subscriber@example.com');

        // Setting up the repository to return the mock entities
        $articleRepo->expects($this->once())->method('findBy')->willReturn([$article]);
        $subscriberRepo->expects($this->once())->method('findAll')->willReturn([$subscriber]);

        // Assigning the repositories to the EntityManager mock
        $entityManager->expects($this->any())->method('getRepository')
            ->willReturnMap([
                [Article::class, $articleRepo],
                [Subscriber::class, $subscriberRepo],
            ]);

        // Mock the Mail facade to prevent actual email sending
        Mail::fake();

        // Run the job
        $job = new SendArticlesToSubscribers($entityManager);
        $job->handle();

        // Assert that the ArticleNotification mailable was sent
        Mail::assertSent(ArticlesNotification::class, function ($mail) use ($subscriber, $article) {
            $mail->build();

            // Assert that the email was sent to the correct recipient
            $this->assertTrue($mail->hasTo($subscriber->getEmail()));

            // Assert that the HTML content contains specific text
            $html = $mail->render();
            $this->assertStringContainsString('<h1>New Articles: 1</h1>', $html);
            $this->assertStringContainsString('<h2>'.$article->getTitle().'</h2>', $html);
            $this->assertStringContainsString('<p>'.$article->getAbstract().'</p>', $html);
            $this->assertStringContainsString('<p>'.$article->getText().'</p>', $html);

            return true;
        });
    }
}