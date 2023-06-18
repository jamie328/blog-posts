<?php

namespace App\UseCase\Post\Create;

use App\Exceptions\PostErrorException;
use App\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Log;

class UseCase
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * 主程式
     *
     * @param  Request $request
     * @return Response
     */
    public function execute(Request $request)
    {
        try {
            // 1. 處理進來資料
            $data = collect($request)->toArray();
            // 2. 執行其商業邏輯 create post
            $newPost = $this->postRepository->createPost($data);
            // 3. 回 response
            if (empty($newPost)) {
                return $this->setResponse(400, 'Created post failed!');
            }
            return $this->createResponse($newPost);
        } catch (\Throwable $e) {
            Log::info(sprintf('%s::%s Error: %s', __CLASS__, __FUNCTION__, $e->getMessage()));
            throw new PostErrorException($e->getMessage());
        }
    }

    /**
     * 處理 Response
     *
     * @param Post $post
     * @return Response
     */
    private function createResponse(Post $post): Response
    {
        $response = new Response();
        $response->format($post);
        return $response;
    }

    /**
     * set error response
     *
     * @param  integer  $code
     * @param  string   $message
     * @return Response
     */
    private function setResponse(int $code = 201, string $message = ''): Response
    {
        $response = new Response();
        $response->code = $code;
        $response->message = $message;
        return $response;
    }
}
