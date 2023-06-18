<?php

namespace App\UseCase\Comment\Create;

use App\Comment;
use Carbon\Carbon;

class Response
{
    /**
     *  定義 response 回傳格式
     */
    public $code = 201;
    private $data = [];
    public $message = 'Created';

    /**
     *  定義回傳格式
     */
    public function format(Comment $comment): void
    {
        $this->data = $comment->toArray();
    }

    /**
     *
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
