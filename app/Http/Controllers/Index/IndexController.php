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
    private $category;
    private $recommendation;
    private $category_list;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        // 菜单导航 列表
        $this->category = Cache::get('category');
        $this->category_list = Cache::get('category_list');
        if (!$this->category) {
            $this->category = DB::table('index_article_category')->where('state',1)->orderBy('sort')->get();
            foreach ($this->category as $value) {
                $this->category_list[$value->word] = $value->name;
            }
            Cache::put('category',$this->category, 60*12);  // 12小时
            Cache::put('category_list',$this->category_list, 60*12);  // 12小时
            Log::info('1');
        }
        //  阅读推荐
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

        // 首页 第N页数据
        $article_list = DB::table('toutiao_article_list as a')
            ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
            ->whereIn('a.category_id',$category_index_list?:[])
            ->orderBy('a.create_date','desc')
            ->paginate(20);

        return view('Index.index')
            ->with('category_menu',$this->category)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category','new')  // 类型 key
            ->with('category_list',$this->category_list)  // 类型 key->name list
            ->with('recommendation', $this->recommendation) // 推荐
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
        // 第N页数据
        $article_list = DB::table('toutiao_article_list as a')
            ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
            ->whereIn('a.category_id',$category_list?:[])
            ->orderBy('a.create_date','desc')
            ->paginate(20);

        return view('Index.index')
            ->with('category_menu', $this->category)  //菜单栏
            ->with('list',$article_list)
            ->with('category',$category)
            ->with('category_list',$this->category_list)
            ->with('recommendation', $this->recommendation)
            ;
    }

    function article($id){

        $data = Cache::get('article_l_'.$id);
        if (!$data) {
            $data = DB::table('toutiao_article_list as a')
                ->leftJoin('toutiao_author as b', 'b.author_id', '=', 'a.author_id')
                ->where('a.id', $id?: 0)
                ->first();

            abort_if(!$data,404,'not found article info');
            $article = DB::table("toutiao_article_0{$data->article_table_tag}")->where('id',$data->article_id)->first();
            abort_if(!$article,404, 'not found article ');
            $data->article=filterArticle($id?: 0,$article->article);

            Cache::put('article_l_'.$id,$data, 60*24*2);
        }

        $category = Cache::get('article_c_'.$data->category_id);
        if (!$category) {
            $aa = DB::table('relation_category as a')
                ->leftJoin('index_article_category as b', 'b.category_index_id', '=', 'a.index_id')
                ->where('a.category_id', $data->category_id)
                ->where('b.state',1)
                ->groupBy('a.index_id')
                ->pluck('word');
            if (count($aa) >=2) {
                foreach ($aa as $item){
                    if ($item == 'new') {
                        continue;
                    }
                    $category = $item;
                }
            }else {
                $category = $aa[0];
            }
            Cache::put('article_c_'.$data->category_id, 60*24*2);
        }


        DB::table('toutiao_article_list')->where('id', $id?:0)->increment('click_amount');

        return view('Index.article')
            ->with('category_menu',$this->category)  //菜单栏;
            ->with('data',$data)
            ->with('category',$category)
            ->with('category_list',$this->category_list)
            ->with('recommendation', $this->recommendation)
            ;
    }
    function getList($like='') {

        $category_index_list= Cache::get('category_index_list');
        if (!$category_index_list) {
            $category_index_list = DB::table('relation_category')->where('index_id','=', 1)->pluck('category_id');
            Cache::put('category_index_list',$category_index_list,60*12);
        }
        $like_arr = explode('-', $like);

        $article_list = DB::table('toutiao_article_list as a')
            ->leftJoin('toutiao_article_category as b', 'a.category_id','=','b.category_id')
            ->whereIn('a.category_id',$category_index_list?:[])
            ->where(function ($query) use ($like_arr) {
                if ($like_arr){
                    foreach ($like_arr as $item) {
                        $query->orWhere('a.title', 'like', '%'. $item .'%');
                    }
                }
            })
            ->select('a.id', 'a.title', 'a.image_url')
            ->orderBy('a.create_date','desc')
            ->limit(20)
            ->get();
        $data = [];
        foreach ($article_list as $k=>$item) {
            $data[$k]['article_url'] = "http://www.vbaodian.cn/article/" . $item->id;
            $data[$k]['image_url'] = urlFilter($item->image_url);
            $data[$k]['title'] = filterTitle($item->id, $item->title);
        }
//        echo $like;
        return response($data, 200);
    }


    function test(){
        $data = DB::table('toutiao_article_list as a')
            ->leftJoin('toutiao_author as b', 'b.author_id', '=', 'a.author_id')
            ->where('a.id', 77307)
            ->first();

        abort_if(!$data,404,'not found article info');
        $article = DB::table("toutiao_article_0{$data->article_table_tag}")->where('id',$data->article_id)->first();
        abort_if(!$article,404, 'not found article ');
        $data->article=filterArticle(77307,$article->article);


//        $users = DB::select(" select * from relation_category group by category_id");
        $aa = DB::table('relation_category as a')
            ->leftJoin('index_article_category as b', 'b.category_index_id', '=', 'a.index_id')
            ->where('a.category_id', $data->category_id)
            ->groupBy('a.index_id')
            ->pluck('word');
        if (count($aa) >=2) {
            foreach ($aa as $item){
                if ($item == 'new') {
                    continue;
                }
                $category = $item;
            }
        }else {
            $category = $aa[0];
        }
        echo $category;


        dd([$data,$aa]);
    }

}