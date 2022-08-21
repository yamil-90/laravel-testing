<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_fetches_trending_articles()
    {
        Article::factory()->count(3)->create();
        Article::factory()->create(['read' => 10]);
        $mostPopular = Article::factory()->create(['read' => 20]);

        $articles = Article::trending();

        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }

}
