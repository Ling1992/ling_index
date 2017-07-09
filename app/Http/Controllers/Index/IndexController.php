<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 23/06/2017
 * Time: 3:08 PM
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    const CATEGORY_MENU=[
        'new'=>'推荐',
        'entertainment'=>'娱乐',
        'sports'=>'体育',
        'finance'=>'经济',
        'technology'=>'科技',
        'society'=>'社会',
        'international'=>'国际',
        'funny'=>'搞笑',
        'pic_text'=>'图文',
        'game'=>'游戏',
        'regimen'=>'养生',
        'story'=>'故事',
        'other'=>'其他'];
    function index(Request $request){
        $input = $request->all();
        Log::info('ling', $input);
        Log::info('ling', self::CATEGORY_MENU);
        return view('Index.index',['category_menu'=>self::CATEGORY_MENU]);
    }
}