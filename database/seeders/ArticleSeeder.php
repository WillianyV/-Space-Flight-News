<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::create([
            'featured' => false,
            'title'=> 'Relançamento dos livros de Harry Potter',
            'url'=> 'https://www.google.com/',
            'imageUrl'=> 'harry-potter.png',
            'newsSite'=> 'https://www.google.com/',
            'summary'=> 'Relançamento dos livros de Harry Potter em capa dura, com ilustrações da autora.',
            'publishedAt'=> '2023-01-19',
            'launche_id'=> 1,
            'event_id'=> 1,
        ]);
    }
}
