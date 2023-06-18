<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'author',
        'status',
        'is_allowed_comments',
        'updated_at'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
