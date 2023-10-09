<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'body',
        'media'
    ];

    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
