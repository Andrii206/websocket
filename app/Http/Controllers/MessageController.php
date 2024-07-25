<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        $messages = MessageResource::collection($messages)->resolve();
        return inertia('Message/Index', compact('messages'));
        
    }


    public function store(StoreRequest $request)
    {
        Log::info('lox');
        $data = $request->validated();
        Log::info($data);
        $message = Message::create($data); 

        broadcast(new StoreMessageEvent($message))->toOthers();
        Log::info($message);
        return MessageResource::make($message)->resolve();
    }
}
