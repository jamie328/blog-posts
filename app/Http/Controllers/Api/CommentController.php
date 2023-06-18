<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CommentErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UseCase\Comment\Create\Request as CreateCommentRequest;
use App\UseCase\Comment\Create\UseCase as CreateCommentUseCase;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CommentErrorException
     */
    public function createComment(Request $request): \Illuminate\Http\JsonResponse
    {
        // input
        $input = new CreateCommentRequest();
        $payload = $input->transformPayload($request);
        $validateResult = $input->validate($payload);
        if (!$validateResult['status']) {
            return response()->json(['code' => 422, 'message' => $validateResult['message'], 'data' => []], 422);
        }
        $input->toDTO($payload);
        // 2. 新增 useCase 實例 interactor
        $interactor = new CreateCommentUseCase(new CommentRepository());
        // 3. useCase 執行商業邏輯
        $response = $interactor->execute($input);
        // 4. 回吐 response
        return response()->json(['code' => $response->code, 'message' => $response->message, 'data' => $response->getData()], $response->code);
    }
}
