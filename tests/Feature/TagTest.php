<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_index_news()
    {
        $response = $this->get('/api/tags');
        $response->assertStatus(200);
    }

    public function test_store_tag()
    {
        $faker = $faker =  \Faker\Factory::create();
        $response =  $this->post('/api/tags',[
            'name'     => $faker->slug,
            'link'      => $faker->unique()->text
        ]);

        $response->assertStatus(201);
    }

    public function test_show_tag()
    {
        $tag_id = Tag::first()->value('id');
        $response = $this->get("/api/tags/$tag_id");
        $response->assertStatus(200);
    }

    public function test_update_news()
    {
        $faker = $faker =  \Faker\Factory::create();
        $tag_id = Tag::first()->value('id');
        $response = $this->patch("/api/tags/$tag_id",[
            'name'     => $faker->slug,
            'link'      => $faker->unique()->word
        ]);
        $response->assertStatus(200);
    }

    public function test_destroy_news()
    {
        $tag_id = Tag::first()->value('id');
        $response = $this->delete("/api/tags/$tag_id");
        $response->assertStatus(204);
        $this->test_store_tag();
    }

    public function test_create_with_tags()
    {
        $faker = $faker =  \Faker\Factory::create();
        $tags = Tag::first()->pluck('id')->toArray();
        $str_tags = implode(',', $tags);
        $response =  $this->post('/api/news',[
            'title'     => $faker->slug,
            'body'      => $faker->text,
            'link'      => $faker->url,
            'tags'      => $str_tags
        ]);

        $response->assertStatus(201);
    }

    public function test_attach_tags()
    {
        $tags = Tag::first()->pluck('id')->toArray();
        $str_tags = implode(',', $tags);
        $news_id = News::first()->value('id');
        $response =  $this->patch("/api/news/$news_id",[
            'tags' => $str_tags
        ]);
        $response->assertStatus(200);
    }

    public function test_detach_tags()
    {
        $tags = Tag::first()->pluck('id')->toArray();
        $str_tags = implode(',', $tags);
        $news_id = News::first()->value('id');
        $response =  $this->patch("/api/news/$news_id",[
            'tags' => $str_tags
        ]);
        $response->assertStatus(200);
    }

    public function test_find_news_by_tags()
    {
        $tags = Tag::inRandomOrder()->take(2)->pluck('id')->toArray();
        $str_tags = implode(',', $tags);
        $response = $this->get("/api/news?".$str_tags);
        $response->assertStatus(200);
    }

}
