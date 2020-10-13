<?php


namespace Hanyun\Admin;


use Illuminate\Http\JsonResponse;

trait Response
{
    public static function success($data = [], $msg = 'success', $code = 200): JsonResponse
    {
        return response()->json(['code' => $code, 'msg' => $msg, 'data' => $data,]);
    }

    public static function error($msg = 'error', $data = [], $code = 200): JsonResponse
    {
        return response()->json(['code' => $code, 'msg' => $msg, 'data' => $data,]);

    }
}
