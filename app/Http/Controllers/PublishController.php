<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Jobs\PublishToSubscribers;
use App\Http\Controllers\Controller;
use App\Models\Message;

class PublishController extends Controller
{
    public function __invoke(Request $request, $title)
    {
        $data = $request->all();
        
        $topic = Topic::firstOrCreate(['title' => $title]);

        $message = Message::create(['message' => $data, 'topic_id' => $topic->id ]);
               
        PublishToSubscribers::dispatch($topic, $data);

        return response()->json([], 201);
    }
}
