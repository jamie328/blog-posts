<?php
namespace App\Repositories;

use App\Post;

class PostRepository
{
    /**
     * create post
     * @param  array $data
     * @return Post
     */
    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * @param int $id
     * @return Post|null
     */
    public function getPostById(int $id): ?Post
    {
        return Post::
            select(
                'id',
                'title',
                'content',
                'author',
                'status',
                'is_allowed_comments',
                'created_at',
                'updated_at'
            )
            ->where('id', $id)
            ->first();
    }
}
