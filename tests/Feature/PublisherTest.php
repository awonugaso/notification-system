<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublisherTest extends TestCase
{
    use  RefreshDatabase, WithFaker;

    function test_publisher_can_post_to_subscribers(){

        $this->withExceptionHandling();
        
        $title = $this->faker->word();

        $this->post("/publish/{$title}", [
            "message" => "hello"
        ]);

        $response = $this->post("subscribe/{$title}", [
            'url' => "https://subscriber.test/test1"
        ]);
        
        $response->assertStatus(201);
        $response->assertJson([
            'url' => "https://subscriber.test/test1",
            'topic' => $title,
        ]);

    }

}
