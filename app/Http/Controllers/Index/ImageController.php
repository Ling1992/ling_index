<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 18/08/2017
 * Time: 5:48 PM
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ImageController extends Controller
{
    protected $image_cache_time = 15 * 24 * 60 * 60;

    function index(Request $request){

        $url = $request->input("url", asset('img/blank.gif'));
//        Log::info('ling',[$request->server()]);
        Log::info('ling',[$url]);
        $modified_time = $request->server('HTTP_IF_MODIFIED_SINCE');

        if ($modified_time) {
            $modified_time_sec = strtotime($modified_time);
            if (($modified_time_sec + $this->image_cache_time) >= time()){
                return response('', 304);
            }
        }

        $data = @file_get_contents($url);

        if ($data == null) {
            $data = "";
        }
        $strUrlMd5 = md5($url);
        $image_data = Cache::get($strUrlMd5);
        if (!$image_data) {
            Cache::put($strUrlMd5,$data, 60*24);  // 12小时
            $image_data = $data;
        }

        return response($image_data)->withHeaders([
            'Last-Modified'=>gmdate("D, d M Y H:i:s \G\M\T",time()),
            'Cache-Control'=>'private, max-age=' . $this->image_cache_time , // 15 天
            'Content-Length'=> strlen($image_data),
            'Pragma'=>'private',
            'Expire'=> gmdate("D, d M Y H:i:s \G\M\T",strtotime(" 15 day")),
            'Content-type'=>'image/jpeg',
        ]);
    }
}