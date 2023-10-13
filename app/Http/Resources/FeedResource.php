<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserLikeResource;
use App\Http\Resources\CommentResource;

class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_likes = UserLikeResource::collection($this->likes);
        $liked = false;

        foreach ($user_likes as $like) {
            if ($like->user->id === auth()->user()->id) {
                $liked = true;
                break;
            }
        }

        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->first_name . ' ' . $this->user->last_name,
                'profile_picture' => $this->user->profile_picture,
            ],
            'body' => $this->body,
            'media' => $this->media,
            'liked' => $liked,
            'like_count' => $this->likes->count(),
            'user_likes' => UserLikeResource::collection($this->likes),
            'comment_count' => $this->comments->count(),
            'comments' => CommentResource::collection($this->comments),
            'created_at' => $this->created_at->format('F m, Y - h:i A'),
            'show_comments' => false
        ];
    }
}
