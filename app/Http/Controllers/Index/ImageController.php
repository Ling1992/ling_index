<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 18/08/2017
 * Time: 5:48 PM
 */

namespace App\Http\Controllers\Index;


use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;

class ImageController
{
    function image(Request $request){
        $url = $request->input("url");

//        Log::info('ling', [$request->server()]);
        if ( $request->server("HTTP_IF_MODIFIED_SINCE") ){
//            Log::info('ling',['last_time'=>strtotime(preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE'])),'now'=>time()]);
            if (time() <= strtotime(preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE'])))
                return response('',304)->header('LAST-MODIFIED',$request->server("HTTP_IF_MODIFIED_SINCE"));
        }
//        Log::info('ling', [$url]);
        return response(file_get_contents($url))->withHeaders([
            "Cache-Control"=>"private, max-age=10800, pre-check=10800",
            "Pragma"=>"private",
            "Expires"=>date(DATE_RFC822, strtotime(" 2 day")),
            "Last-Modified"=>date(DATE_RFC822, strtotime(" 2 day")),
            "Content-type"=>"image/jpeg",
        ]);
    }
}