<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Event;
use App\Models\Launche;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ArticleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uma CRON para ser executada diariamente às 9h e armazenar os novos artigos ao seu banco de dados';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_articles = Http::get("https://api.spaceflightnewsapi.net/v3/articles");
        $articles = json_decode($all_articles);
        //Os launches e events estão vindo vazios.

        foreach ($articles as $article) {
            if (!(Article::where('title', $article->title)->exists())) {
                Article::create([
                    'featured' => $article->featured,
                    'title' => $article->title,
                    'url' => $article->url,
                    'imageUrl' => $article->imageUrl,
                    'newsSite' => $article->newsSite,
                    'summary' => $article->summary,
                    'publishedAt' => $article->publishedAt
                ]);
            }
        }

        $this->info('Novos Artigos adicionados com sucesso');
        return Command::SUCCESS;
    }
}
