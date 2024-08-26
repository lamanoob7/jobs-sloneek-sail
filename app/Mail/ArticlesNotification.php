<?php

namespace App\Mail;

use App\Entities\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticlesNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $articles;

    /**
     * Create a new message instance.
     */
    public function __construct(array $articles)
    {
        $this->articles = $articles;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Articles ' . count($this->articles))
                    ->view('emails.articles_notification')
                    ->with([
                        'articlesCount' => count($this->articles),
                        'articles' => $this->articles
                    ]);
    }
}
