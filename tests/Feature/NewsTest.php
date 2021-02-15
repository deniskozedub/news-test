<?php

namespace Tests\Feature;

use App\Models\News;
use Tests\TestCase;

class NewsTest extends TestCase
{
    public function test_index_news()
    {
        $response = $this->get('/api/news');
        $response->assertStatus(200);
    }

    public function test_store_news()
    {
        $faker = $faker =  \Faker\Factory::create();
        $response =  $this->post('/api/news',[
            'title'     => $faker->slug,
            'body'      => $faker->text,
            'link'      => $faker->url
        ]);

        $response->assertStatus(201);
    }

    public function test_show_news()
    {
        $news_id = News::first()->value('id');
        $response = $this->get("/api/news/$news_id");
        $response->assertStatus(200);
    }

    public function test_update_news()
    {
        $faker = $faker =  \Faker\Factory::create();
        $news_id = News::first()->value('id');
        $response = $this->patch("/api/news/$news_id",[
            'title'     => $faker->slug,
            'body'      => $faker->text,
            'link'      => $faker->url
        ]);
        $response->assertStatus(200);
    }

    public function test_destroy_news()
    {
        $news_id = News::first()->value('id');
        $response = $this->delete("/api/news/$news_id");
        $response->assertStatus(204);
        $this->test_store_news();
    }

    public function test_counter_news()
    {
        $news = News::first();
        $news->newsCounter();
        $this->assertNotEquals(0, $news->counter);
    }
}
