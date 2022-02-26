<?php

namespace Package\Component\Common\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回正确数据.
     *
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($message, $errCode = 0, $data = [])
    {
        $statusCode = 200;

        if (is_string($message)) {
            return response()->json(['error_code' => $errCode, 'message' => $message, 'data' => $data], $statusCode);
        }

        return response()->json($message, $statusCode);
    }

    /**
     * 统一返回错误信息.
     *
     * @param string $message 错误消息的内容
     * @param int    $errCode 扩展自定义区分不同类型的错误
     * @param array  $data    需要附加的数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $errCode = 1000, $data = null)
    {
        $statusCode = 400;

        if ($data) {
            return response()->json(['error_code' => $errCode, 'message' => $message, 'data' => $data], $statusCode);
        }

        return response()->json(['error_code' => $errCode, 'message' => $message], $statusCode);
    }
}
