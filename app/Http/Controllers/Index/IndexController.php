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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    protected $category;
    protected $recommendation;
    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        // 菜单导航 列表
        $this->category = Cache::get('category');
        if (!$this->category) {
            $this->category = DB::table('index_article_category')->orderBy('sort')->get();
            Cache::put('category',$this->category, 60*12);  // 12小时
            Log::info('1');
        }
        // 阅读推荐
        $this->recommendation = Cache::get('recommendation');
        if (!$this->recommendation) {
            // 首页 category 详细列表
            $category_index_list= Cache::get('category_index_list');
            if (!$category_index_list) {
                $category_index_list = DB::table('relation_category')->where('index_id','=', 1)->pluck('category_id');
                Cache::put('category_index_list',$category_index_list,60*12);
                Log::info('2');
            }
            $this->recommendation = DB::table('toutiao_article_list')
                ->whereIn('category_id',$category_index_list?:[])
                ->orderBy('create_date','desc')
                ->limit(5)
                ->get();
            Cache::put('recommendation',$this->recommendation, 60*12);
            Log::info('3');
        }

    }

    function index(Request $request){

        $input = $request->all();
        Log::info('ling', $input);

        // 首页 category 详细列表
        $category_index_list= Cache::get('category_index_list');
        if (!$category_index_list) {
            $category_index_list = DB::table('relation_category')->where('index_id','=', 1)->pluck('category_id');
            Cache::put('category_index_list',$category_index_list,60*12);
            Log::info('4');
        }

        $page_ = $request->input('page', '1');
        // 首页 第N页数据
        $article_list = Cache::get('article_index_list_'.$page_);
        if (!$article_list) {
            $article_list = DB::table('toutiao_article_list as a')
                ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
                ->whereIn('a.category_id',$category_index_list?:[])
                ->orderBy('a.create_date','desc')
                ->paginate(20);
            Cache::put('article_index_list_'.$page_,$article_list, 5);
            Log::info('5');
        }

        // 获取 首页 index_category 名称
        $category_index_word = Cache::get('category_index_word');
        if (!$category_index_word) {
            $category_index_word = DB::table('index_article_category')->where('category_index_id','=', '1')->value('word');
            Cache::put('category_index_word',$category_index_word,60*12);
            Log::info('6');
        }

        return view('Index.index')
            ->with('category_menu',$this->category)  //菜单栏
            ->with('list',$article_list)
            ->with('category',$category_index_word)
            ->with('recommendation', $this->recommendation)
            ;
    }
    function category($category, Request $request){

        $input = $request->all();
        Log::info('ling', $input);
        // category 详细列表
        $category_list= Cache::get("category_{$category}_list");
        if (!$category_list) {
            $category_list = DB::table('relation_category as a')
                ->leftJoin('index_article_category as b', 'a.index_id','=','b.category_index_id')
                ->where('b.word','=', $category)
                ->pluck('a.category_id');
            Cache::put("category_{$category}_list",$category_list,60*12);
            Log::info('7');
        }
        $page_ = $request->input('page', '1');
        // 第N页数据
        $article_list = Cache::get("category_{$category}_list_$page_");
        if (!$article_list) {
            $article_list = DB::table('toutiao_article_list as a')
                ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
                ->whereIn('a.category_id',$category_list?:[])
                ->orderBy('a.create_date','desc')
                ->paginate(20);
            Cache::put("category_{$category}_list_$page_",$article_list, 5);
            Log::info('8');
        }

        return view('Index.index')
            ->with('category_menu', $this->category)  //菜单栏
            ->with('list',$article_list)
            ->with('category',$category)
            ->with('recommendation', $this->recommendation)
            ;
    }

    function article($id){

        $data = Cache::get('article_l_'.$id);
        if (!$data) {
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
            Cache::put('article_l_'.$id,$data, 60*24*2);
        }
        return view('Index.article')
            ->with('category_menu',$this->category)  //菜单栏;
            ->with('data',$data)
            ->with('category',$data->category_name)
            ->with('recommendation', $this->recommendation)
            ;
    }

    function test(){
        $category_list = DB::table('relation_category as a')
            ->leftJoin('index_article_category as b', 'a.index_id','=','b.category_index_id')
            ->where('b.word','=', 'entertainment')
            ->pluck('a.category_id');
        $article_list = DB::table('toutiao_article_list as a')
            ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
            ->whereIn('a.category_id',$category_list?:[])
            ->orderBy('a.create_date','desc')
            ->paginate(20);
        dd($article_list);
    }
}