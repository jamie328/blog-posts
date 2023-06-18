<?php

namespace App;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'name',
        'messages',
        'updated_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
