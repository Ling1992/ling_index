<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 23/06/2017
 * Time: 3:08 PM
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use XS;
use XSDocument;
use XSTokenizerScws;

class IndexController extends Controller
{
    private $recommendation;
    private $category_list;
    private $movie_list;
    private $paginator;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {

        // 菜单导航 列表
        $this->category_list = [
            'new'=>['key'=>'娱乐','name'=>'最新娱乐'],
            'food'=>['key'=>'美食','name'=>'美食'],
            'game'=>['key'=>'游戏','name'=>'游戏'],
            'fashion'=>['key'=>'时尚','name'=>'时尚'],
            'travel'=>['key'=>'旅游','name'=>'旅游'],
            'photography'=>['key'=>'摄影','name'=>'摄影'],
            'funny'=>['key'=>'搞笑','name'=>'搞笑'],
            'comic'=>['key'=>'动漫','name'=>'动漫'],
            'emotion'=>['key'=>'情感','name'=>'情感'],
//            'story'=>['key'=>'故事','name'=>'故事'],
//            'sports'=>['key'=>'体育','name'=>'体育'],
//            'car'=>['key'=>'汽车','name'=>'汽车'],
//            'science_all'=>['key'=>'科学','name'=>'科学'],
//            'baby'=>['key'=>'育儿','name'=>'育儿'],
//            'digital'=>['key'=>'数码','name'=>'数码'],
//            'design'=>['key'=>'设计','name'=>'设计'],
//            'tech'=>['key'=>'科技','name'=>'科技'],
//            'house'=>['key'=>'房产','name'=>'房产'],
//            'edu'=>['key'=>'教育','name'=>'教育'],
//            'culture'=>['key'=>'文化','name'=>'文化'],
//            'psychology'=>['key'=>'心理','name'=>'心理'],
            'astrology'=>['key'=>'星座','name'=>'星座'],
//            'career'=>['key'=>'心理','name'=>'心理'],
            'pet'=>['key'=>'宠物','name'=>'宠物'],
//            'home'=>['key'=>'家居','name'=>'家居'],
            'beauty'=>['key'=>'美女','name'=>'美女'],
//            'movie'=>['key'=>'电影','name'=>'电影'],
//            'wedding'=>['key'=>'婚嫁','name'=>'婚嫁'],
        ];

        $this->paginator = $paginator = new Paginator(null,20);

        //  阅读推荐
        $this->recommendation = Cache::get('recommendation');
        if (!$this->recommendation) {
            $xs = new XS("demo");

            $xs->search->setSort('create_date',false);
            $xs->search->setQuery("娱乐 OR 艳照 OR 明星");
            $xs->search->setLimit(5);
            $this->recommendation = $xs->search->search();

            Cache::put('recommendation',$this->recommendation, 60*6); //6 小时

        }
        // 57-电影
        $this->movie_list = Cache::get('movie_list');
        if (!$this->movie_list) {
            $http_client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'http://vtalking.cn/index.php/api/api_stream',
                // You can set any number of default request options.
                'timeout'  => 5.0,
            ]);
            $response = $http_client->request('GET');
            if ($response->getStatusCode() == 200) {
                $this->movie_list = \GuzzleHttp\json_decode($response->getBody());
                if (count($this->movie_list) <= 1) {
                    $this->movie_list = [0];
                }
            }else{
                $this->movie_list = [0];
            }
            Cache::put('movie_list',$this->movie_list, 60*2);  // 2小时
        }

    }

    function index(){

        $xs = new XS("demo");

        $xs->search->setSort('create_date',false);
        $xs->search->setQuery("category:".$this->category_list['new']['key']);
//        $xs->search->setQuery("");
        $xs->search->setLimit($this->paginator->perPage(),($this->paginator->currentPage() -1 ) * $this->paginator->perPage());

        $article_list = $xs->search->search();
        $count = $xs->search->getLastCount();


        $paginator =new LengthAwarePaginator($this->paginator->items(), $count, $this->paginator->perPage(), $this->paginator->currentPage(), [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $this->paginator->getPageName(),
        ]);

        return view('Index.index')
            ->with('paginator', $paginator)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category','new')  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ->with('movie_list', $this->movie_list) // 57-电影
            ;
    }

    function category($category){


        $xs = new XS("demo");

        $xs->search->setSort('create_date',false);
        $xs->search->setQuery("category:".$this->category_list[$category]['key']);
//        $xs->search->setQuery("");
        $xs->search->setLimit($this->paginator->perPage(),($this->paginator->currentPage() -1 ) * $this->paginator->perPage());

        $article_list = $xs->search->search();
        $count = $xs->search->getLastCount();

        $paginator =new LengthAwarePaginator($this->paginator->items(), $count, $this->paginator->perPage(), $this->paginator->currentPage(), [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $this->paginator->getPageName(),
        ]);

        return view('Index.index')
            ->with('paginator', $paginator)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category', $category)  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ->with('movie_list', $this->movie_list) // 57-电影
            ;
    }

    function article($id){

        $xs = new XS("demo");
        $tokenizer = new XSTokenizerScws;

        $xs->setScheme($this->getXSFieldScheme(true));

        $xs->search->setQuery("article_id:".$id);
        $xs->search->setLimit(1);

        $article_list = $xs->search->search();
        $data = $article_list[0];

        $category = 'new';
        foreach ($this->category_list as $k => $v) {
            if ($v['name'] == $data->f('category')) {
                $category = $k;
            }
        }
        
        $top = $tokenizer->getTops($data->f('title'), 5, 'n,v,vn');

        $temp = [];

        if (count($top) >=1 ) {
            foreach ($top as $v) {
                $temp[] = $v['word'];
            }
        }
        $data->setFields(['keyWord'=>implode(', ', $temp)]);

        return view('Index.article')
            ->with('data',$data)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('category', $category)  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ->with('movie_list', $this->movie_list) // 57-电影
            ;

    }

    function getList($like='') {
        $like_arr = explode('-', $like);

        $sql_str = "";
        if (count($like_arr) >= 1) {
            foreach ($like_arr as $k=>$v) {
                echo $v;
                if ($k == 0) {
                    $sql_str = $v;
                }else {
                    $sql_str = $sql_str . " OR " .$v;
                }
            }
        }

        $xs = new XS("demo");

        $xs->setScheme($this->getXSFieldScheme());
        $xs->search->setSort('create_date',false);

        $xs->search->setQuery($sql_str);
        $xs->search->setLimit(20);

        $article_list = $xs->search->search();

        $data = [];
        foreach ($article_list as $k=>$item) {
            $data[$k]['article_url'] = "http://www.vbaodian.cn/article/" . $item->f('article_id');
            $data[$k]['image_url'] = urlFilter($item->f('title_image'));
            $data[$k]['title'] = filterTitle($item->f('article_id'), $item->f('title'));
        }
//        echo $like;
        return response($data, 200);
    }

    public function clearCache($str, $admin){
        // 是否是纯数字
        if ($admin != "ling") return "true";
        if (is_numeric($str) || is_integer($str)) {
            Cache::forget('title_'.$str);
            Cache::forget('abstract_'.$str);
            Cache::forget('article_'.$str);
        }else {
            Cache::forget($str);
        }
        return "true";

    }

    public function addIpToBlacklist($str, $admin) {
        if ($admin != "ling") return "true";
        $ips = explode(',', $str);
        foreach ($ips as $ip){
            if(!Cache::has('blacklist:'.$ip)) {
                Cache::put('blacklist'.$ip, $ip, 60*12);  //12 小时
            }
        }
    }

    private function getXSFieldScheme($has_article = false){
        $scheme = new \XSFieldScheme();

        $scheme->addField('article_id', array('type' => 'id'));
        $scheme->addField('category', array('index' => 'self', 'tokenizer' => 'full'));
        $scheme->addField('title', array('type' => 'title'));
        $scheme->addField('title_image', array('index' => 'none', 'tokenizer' => 'none'));
        $scheme->addField('abstract', array('index' => 'none', 'tokenizer' => 'none'));

        if ($has_article) {
            $scheme->addField('article', array('type' => 'body', 'cutlen' => 0));
        }else {
            $scheme->addField('article', array('type' => 'body', 'cutlen' => 1));
        }

        $scheme->addField('create_date', array('type' => 'numeric'));
        $scheme->addField('author', array('index' => 'both'));
        $scheme->addField('author_id');
        return $scheme;
    }

    function test()
    {
        // 1 分类查询
        // 2 按id查询
        //

        $id = 103477;
        $xs = new XS("demo");
        $doc = new XSDocument;  // 使用默认字符集
        $xs->index->flushIndex();

//        $xs->getAllFields();
//        $xs->setScheme($this->getXSFieldScheme(true));
        $xs->search->setSort('create_date',false);
//        $xs->search->setSort('article_id',false);
        $xs->search->setLimit(10);

//        $xs->search->setQuery("article_id:".$id);
//        $xs->search->setQuery("");
//        $xs->search->setFacets("category");
        $docs = $xs->search->search();
        $count = $xs->search->getLastCount();

//        foreach ($docs as $v) {
//            echo date('Y-m-d H:i:s', $v->f("create_date"));
//            echo $v->f("create_date");
//            echo "<br />";
//        }
        echo $count;
        dd($docs);

    }

    function test1(){
        $xs = new XS("demo");
        $tokenizer = new XSTokenizerScws;
        $tops = $tokenizer->getTops("因不生育而领养的6大女星，她领养后成功怀孕，却把领养孩子转让", 5, 'n,v,vn');

        dd($tops);
        echo implode(', ', $tops);
    }

    function test2(){
        $xs = new XS("demo");
//        $tokenizer = new XSTokenizerScws;   // 直接创建实例
//
//        $text = '她竟与杨童舒、王丽坤“共伺”一夫？如今人老珠黄的她险被抛弃';
//        $tokenizer->setIgnore();
//        $tokenizer->setDuality();
//        $tokenizer->setMulti(3);
////        $words = $tokenizer->getResult($text);
//        $words = $tokenizer->getTops($text,10,'n,@,i,v,vn');
//        dd($words);
        $xs->index->clean();
        $xs->index->flushIndex();
    }

}