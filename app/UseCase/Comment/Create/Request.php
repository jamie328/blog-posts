<?php

namespace App\UseCase\Comment\Create;

use App\Exceptions\CommentErrorException;
use App\Exceptions\PostErrorException;
use Illuminate\Http\Request as BaseRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Request
{
    /**
     * transform payload
     *
     * @param BaseRequest $request
     * @return array
     */
    public function transformPayload(BaseRequest $request): array
    {
        $column = [
            'post_id',
            'name',
            'messages'
        ];

        $requestData = $request->only($column);
        $requestData['post_id'] = $requestData['post_id'] ? (int) $requestData['post_id'] : 0;
        $requestData['name'] = $requestData['name'] ? (string) filter_var($requestData['name'], FILTER_SANITIZE_STRING) : 'anonymous';
        $requestData['messages'] = $requestData['messages'] ? (string) filter_var($requestData['messages'], FILTER_SANITIZE_STRING) : '';

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
                'post_id' => "required|integer|gt:0",
                'name' => "required|string",
                'messages' => "required|string",
            ];
            $message = [
                'required' => ':attribute 不得為空',
                'string' => ':attribute 須為 string',
                'integer' => ':attribute 須為 integer',
                'gt' => ':attribute 數值錯誤',
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
            throw new CommentErrorException($e->getMessage());
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
