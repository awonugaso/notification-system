<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    protected $topic = null;

      public function test_can_subscribe_to_a_topic()
      {
          $this->withoutExceptionHandling();
          $this->topic = Topic::factory()->create();
  
          $response = $this->post("subscribe/{$this->topic->title}", [
              'url' => "https://subscriber.test/test1"
          ]);
          
          $response->assertStatus(201);
          $response->assertJson([
              'url' => "https://subscriber.test/test1",
              'topic' => $this->topic->title
          ]);
      }

    public function test_same_subscriber_cant_subscribe_to_same_topic_again(){

        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->title}", [
            'url' => "https://subscriber.test/test1"
            ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->title}", [
            'url' => "https://subscriber.test/test1"
            ]);
        
        $response->assertStatus(200);
        $response->assertSeeText('subscribed already');
    }

    public function test_subscription_requires_url(){
        $this->withExceptionHandling();
        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->title}");
        
        $response->assertStatus(422);
    }

    public function test_subscription_requires_a_valid_url(){

        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->title}", ['url' => 'invalid-url']);
        
        $response->assertStatus(422);
    }


}
