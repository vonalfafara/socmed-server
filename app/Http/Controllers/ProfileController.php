<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\FriendRequestResource;

class ProfileController extends Controller
{
    public function getProfile($user_id = false) {
        $profile_id = auth()->user()->id;

        if ($user_id) {
            $profile_id = $user_id;
        }

        $profile = new ProfileResource(User::find($profile_id));
        return response([
            'profile' => $profile
        ], 200);
    }

    public function sendFriendRequest(Request $request) {
        $fields = $request->validate([
            'user_to' => 'required'
        ]);

        FriendRequest::create([
            'user_id' => auth()->user()->id,
            'user_to' => $fields['user_to']
        ]);

        return response([
            'message' => 'Friend request sent'
        ], 201);
    }

    public function getFriendRequests() {
        $fr = FriendRequestResource::collection(FriendRequest::where('user_to', auth()->user()->id)->get());

        return response([
            'data' => $fr,
        ], 200);
    }
    
    public function acceptFriendRequest(Request $request) {
        $fr = FriendRequest::find($request->input('id'));

        Friend::insert([
            [
                'user_id' => auth()->user()->id,
                'friends_with' => $fr['user_id']
            ],
            [
                'user_id' => $fr['user_id'],
                'friends_with' => auth()->user()->id
            ]
        ]);

        $fr->delete();

        return response([
            'message' => 'Friend request accepted'
        ], 201);
    }

    public function rejectFriendRequest(Request $request) {
        FriendRequest::destroy($request->input('id'));

        return response([
            'message' => 'Friend request rejected'
        ], 200);
    }

    public function getSenderFr(string $id) {
        $fr = FriendRequest::where('user_to', $id)->where('user_id', auth()->user()->id)->first();
        $f = Friend::where('friends_with', $id)->where('user_id', auth()->user()->id)->first();

        $response = [
            'has_fr' => $fr || $f ? true : false
        ];
        
        return response($response, 200);
    }
}
