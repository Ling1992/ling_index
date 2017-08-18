<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 18/08/2017
 * Time: 5:48 PM
 */

namespace App\Http\Controllers\Index;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController
{
    function image(Request $request){
        $url = $request->input("url");

        Log::info('ling', [$url]);

        return response(file_get_contents($url))->header("Content-Type", "image/jpeg");
    }
}