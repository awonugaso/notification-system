<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $title)
    {

        $aa = $request->validate([
            'url' => 'required|url:'
        ]);

        $topic = Topic::firstOrCreate(['title' => $title]);

        $url = Str::endsWith($request->url, '/') ? Str::substr($request->url, 0, -1) : $request->url;
        
        $subscriber = Subscription::where([ ['topic_id', $topic->id], ['endpoint', $url] ])->first();
        if(!is_null($subscriber)){
            return response()->json("{$url} subscribed already to '{$topic->title}'", 200);
        }

        $subscriber = $topic->subscribers()->create(['endpoint' => $url]);

        return response()->json([
            'url' => $subscriber->endpoint,
            'topic' => $topic->title
        ], 201);
        
    }
}
