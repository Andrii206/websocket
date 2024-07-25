<?php

namespace App\Http\Controllers;

use App\Events\SendLikeEvent;
use App\Http\Requests\User\SendLikeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia('User/Show', compact('user'));
    }

    public function sendLike(User $user, SendLikeRequest $request)
    {
        $data = $request->validated();
       

        $likeStr = 'Your like from user with id' . $data['from_id'];
        Log::info($likeStr);

        broadcast(new SendLikeEvent($likeStr, $user->id))->toOthers();

        return response()->json([
            'like_str' => $likeStr
        ]);
    }
}
