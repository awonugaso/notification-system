<?php

namespace App\Jobs;

use App\Models\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PublishToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;
    protected $payLoad;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($topic, $data)
    {
        //
        $this->topic = $topic;
        $this->payLoad = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        
        $topic =  Topic::find($this->topic->id);
        
        foreach ($topic->subscribers as $subscriber) {
                    $response = Http::post($subscriber->endpoint, [
                                'topic', $this->topic->title, 
                                'data' => $this->payLoad]);
}
    }
}
