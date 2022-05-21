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
     * @param array $attachData 需要附加的数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($message = 'success', $errCode = 0, $attachData = [])
    {
        $statusCode = 200;

        if (is_string($message)) {
            return response()->json(['error_code' => $errCode, 'message' => $message, 'data' => $attachData], $statusCode);
        }

        return response()->json($message, $statusCode);
    }

    /**
     * 统一返回错误信息.
     *
     * @param string $message    错误消息的内容
     * @param int    $errCode    扩展自定义区分不同类型的错误
     * @param array  $attachData 需要附加的数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message = 'error', $errCode = 1000, $attachData = [])
    {
        $statusCode = 400;

        if ($attachData) {
            return response()->json(['error_code' => $errCode, 'message' => $message, 'data' => $attachData], $statusCode);
        }

        return response()->json(['error_code' => $errCode, 'message' => $message], $statusCode);
    }
}
