<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 23/06/2017
 * Time: 3:08 PM
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

        $page_ = $request->input('page', '0');
//        $article_list = Cache::get('article_list_'.$page_);
//        if (!$article_list) {
            $article_list = DB::table('toutiao_article_list')->orderBy('create_date','desc')->paginate(20);
//            Cache::put('article_list_'.$page_,$article_list, 5);
//            Log::info('set---> article_list cache');
//        }
        return view('Index.index')
            ->with('category_menu',self::CATEGORY_MENU)  //菜单栏
            ->with('list',$article_list)
            ->with('category','new')
            ;
    }
    function category($category, Request $request){
        $input = $request->all();

        Log::info('ling', $input);

        $page_ = $request->input('page', '0');
//        $article_list = Cache::get('article_list_'.$page_);
//        if (!$article_list) {
        $article_list = DB::table('toutiao_article_list')->orderBy('create_date','desc')->paginate(20);
//            Cache::put('article_list_'.$page_,$article_list, 5);
//            Log::info('set---> article_list cache');
//        }
        return view('Index.index')
            ->with('category_menu',self::CATEGORY_MENU)  //菜单栏
            ->with('list',$article_list)
            ->with('category',$category)
            ;
    }

    function article($id){

//        $id = $request->input('index_id', '0');
//        $article = Cache::get('article_l_'.$article_id);
//        if (!$article) {
            $data = DB::table('toutiao_article_list as a')
                ->leftJoin('toutiao_author as b', 'b.author_id', '=', 'a.author_id')
                ->leftJoin('toutiao_article_category as c', 'c.category_id', '=', 'a.category_id')
                ->select('a.*', 'b.*', 'c.*', 'b.name as author_name','c.name as category_name')
                ->where('a.id', $id?:0)
                ->first();

            abort_if(!$data,404,'not found article info');
            $article = DB::table("toutiao_article_0{$data->article_table_tag}")->where('id',$data->article_id)->first();
            abort_if(!$article,404, 'not found article ');
            $data->article=filterArticle($id,$article->article);
//            Cache::put('article_l_'.$article,$article, 60*24*2);
//        }
        return view('Index.article')
            ->with('category_menu',self::CATEGORY_MENU)  //菜单栏;
            ->with('data',$data)
            ->with('category',$data->category_name)
            ;
    }

    function test(){
        $str = '2017-07-14 14:00:00.00';

        $dt = Carbon::parse($str);
        $now = Carbon::now();

        echo $dt;
        echo PHP_EOL;
        echo $now;
        echo PHP_EOL;
        echo $now->diffInMinutes($dt);
    }
}