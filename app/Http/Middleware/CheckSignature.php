<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = env("WX_TOKEN");

        // 将token、timestamp、nonce三个参数进行字典序排序
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        //将三个参数字符串拼接成一个字符串进行sha1加密
        $tmpStr = sha1($tmpStr);
        // 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
        if($tmpStr == $signature){

        }else{
            return false;
        }
        return $next($request);
    }
}
