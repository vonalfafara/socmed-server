<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FeedResource;
use App\Http\Resources\FriendResource;
use App\Models\Post;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'profile_picture' => $this->profile_picture,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'friends' => FriendResource::collection($this->friends),
            'posts' => FeedResource::collection(Post::where('user_id', $this->id)->orderBy('created_at', 'desc')->get())
        ];
    }
}
