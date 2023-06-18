<?php
namespace App\Repositories;

use App\Comment;

class CommentRepository
{
    /**
     * create post
     * @param  array $data
     * @return Comment
     */
    public function createComment(array $data): Comment
    {
        return Comment::create($data);
    }
}
