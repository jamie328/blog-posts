<?php

namespace App\UseCase\Comment\Create;

use App\Exceptions\CommentErrorException;
use App\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Log;

class UseCase
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
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
            // 2. 執行其商業邏輯 create comment
            $post = app(PostRepository::class)->getPostById($data['post_id']);
            if (empty($post)) {
                return $this->setResponse(400, 'Comment can not added in disappeared post!');
            }
            if (!$post->is_allowed_comments) {
                return $this->setResponse(400, 'Post is not allowed comments!');
            }
            $newComment = $this->commentRepository->createComment($data);
            // 3. 回 response
            if (empty($newComment)) {
                return $this->setResponse(400, 'Created comment failed!');
            }
            return $this->createResponse($newComment);
        } catch (\Throwable $e) {
            Log::info(sprintf('%s::%s Error: %s', __CLASS__, __FUNCTION__, $e->getMessage()));
            throw new CommentErrorException($e->getMessage());
        }
    }

    /**
     * 處理 Response
     *
     * @param Comment $comment
     * @return Response
     */
    private function createResponse(Comment $comment): Response
    {
        $response = new Response();
        $response->format($comment);
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
