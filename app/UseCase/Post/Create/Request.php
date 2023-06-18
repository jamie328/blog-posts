<?php

namespace App\UseCase\Post\Create;

use App\Exceptions\PostErrorException;
use Illuminate\Http\Request as BaseRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Request
{
    /**
     *  定義 POST post 的參數
     */

    /**
     * transform payload
     *
     * @param BaseRequest $request
     * @return array
     */
    public function transformPayload(BaseRequest $request): array
    {
        $column = [
            'title',
            'content',
            'author',
            'status',
            'is_allowed_comments',
        ];

        $requestData = $request->only($column);
        $requestData['title'] = $requestData['title'] ? (string) filter_var($requestData['title'], FILTER_SANITIZE_STRING) : '';
        $requestData['content'] = $requestData['content'] ? (string) filter_var($requestData['content'], FILTER_SANITIZE_STRING) : '';
        $requestData['author'] = $requestData['author'] ? (string) filter_var($requestData['author'], FILTER_SANITIZE_STRING) : 'anonymous';
        $requestData['status'] = $requestData['status'] ? (int) $requestData['status'] : 0;
        $requestData['is_allowed_comments'] = $requestData['is_allowed_comments'] ? (int) $requestData['is_allowed_comments'] : 0;

        return $requestData;
    }

    /**
     * 檢查 input 參數
     *
     * @param  array $input
     * @return array
     */
    public function validate(array $input): array
    {
        try {
            $rule = [
                'title' => "required|string",
                'content' => "required|string",
                'author' => "required|string",
                'status' => "required|integer|in:0,1",
                'is_allowed_comments' => "required|integer|in:0,1",
            ];
            $message = [
                'required' => ':attribute 不得為空',
                'string' => ':attribute 須為 string',
                'integer' => ':attribute 須為 integer',
                'in' => ':attribute 數值錯誤',
            ];
            $validator = Validator::make($input, $rule, $message);
            if ($validator->fails()) {
                return [
                    'status' => false,
                    'message' => $validator->errors()->toArray(),
                ];
            }
            return [
                'status' => true,
                'message' => [],
            ];
        } catch (\Throwable $e) {
            Log::error(sprintf('%s::%s Error: %s', __CLASS__, __FUNCTION__, $e->getMessage()));
            throw new PostErrorException($e->getMessage());
        }
    }

    /**
     * 轉換成 object
     *
     * @param  array $input
     * @return void
     */
    public function toDTO(array $input): void
    {
        foreach ($input as $key => $val) {
            $this->$key = $val;
        }
    }
}
