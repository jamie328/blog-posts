<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PostErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UseCase\Post\Create\Request as CreatePostRequest;
use App\UseCase\Post\Create\UseCase as CreatePostUseCase;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws PostErrorException
     */
    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        // input
        $input = new CreatePostRequest();
        $payload = $input->transformPayload($request);
        $validateResult = $input->validate($payload);
        if (!$validateResult['status']) {
            return response()->json(['code' => 422, 'message' => $validateResult['message'], 'data' => []], 422);
        }
        $input->toDTO($payload);
        // 2. 新增 useCase 實例 interactor
        $interactor = new CreatePostUseCase(new PostRepository());
        // 3. useCase 執行商業邏輯
        $response = $interactor->execute($input);
        // 4. 回吐 response
        return response()->json(['code' => $response->code, 'message' => $response->message, 'data' => $response->getData()], $response->code);
    }
}
