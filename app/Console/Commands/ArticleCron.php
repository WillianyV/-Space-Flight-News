<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleEvent;
use App\Models\ArticleLauche;
use App\Models\Event;
use App\Models\Launche;
use GuzzleHttp\Client;
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
        // $all_articles = Http::get("https://api.spaceflightnewsapi.net/v3/articles");
        // $articles = json_decode($all_articles);

        $client = new Client();
        $response = $client->request('GET', 'https://api.spaceflightnewsapi.net/v3/articles');
        $articles = json_decode($response->getBody(), true);

        foreach ($articles as $article) {
            // Acessa os campos da resposta JSON
            $launchesData = $article['launches'];
            $eventsData = $article['events'];

            // Cria uma nova instância da classe Article
            if (!(Article::where('id', $article['id'])->exists())) {
                Article::create([
                    'id' => $article['id'],
                    'featured' => $article['featured'],
                    'title' => $article['title'],
                    'url' => $article['url'],
                    'imageUrl' => $article['imageUrl'],
                    'newsSite' => $article['newsSite'],
                    'summary' => $article['summary'],
                    'publishedAt' => $article['publishedAt']
                ]);

                // Cria as novas instâncias de Launche e ArticleLauche
                foreach ($launchesData as $launchData) {
                    if (!(Launche::where('id', $launchData['id'])->exists())) {
                        Launche::create(['id' => $launchData['id'],'provider' => $launchData['provider']]);
                    }
                    ArticleLauche::create([
                        'article_id' => $article['id'],
                        'launch_id' => $launchData['id']
                    ]);
                }

                foreach ($eventsData as $eventData) {
                    if (!(Event::where('id', $eventData['id'])->exists())) {
                        Event::create(['id' => $eventData['id'],'provider' => $eventData['provider']]);
                    }
                    ArticleEvent::create([
                        'article_id' => $article['id'],
                        'launch_id' => $eventData['id']
                    ]);
                }
            }
        }

        $this->info('Novos Artigos adicionados com sucesso');
        return Command::SUCCESS;
    }
}
