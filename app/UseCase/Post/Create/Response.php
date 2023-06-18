<?php

namespace App\UseCase\Post\Create;

use App\Post;
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
    public function format(Post $post): void
    {
        $this->data = $post->toArray();
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
