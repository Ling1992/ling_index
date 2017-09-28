<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 28/09/2017
 * Time: 10:12 AM
 */


namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use XS;
use XSDocument;
use XSTokenizerScws;

class AttachController extends Controller
{

    public function clearCache($str, $admin){
        // 是否是纯数字
        if ($admin != "ling") return "true";
        if (is_numeric($str) || is_integer($str)) {
            Cache::forget('title_'.$str);
            Cache::forget('abstract_'.$str);
            Cache::forget('article_'.$str);
        }else if ($str == 'all') {
            Cache::flush();
        }else {
            Cache::forget($str);
        }
        return "true";

    }

    public function addIpToBlacklist($str, $admin) {

        if ($admin != "ling") {
            echo 'hello!!';
            return "true";
        }

        $ips = explode(',', $str);
        foreach ($ips as $ip){
            if(!Cache::has('blacklist:'.$ip)) {
                Cache::put('blacklist:'.$ip, $ip, 60*12);  //12 小时
                echo 'hello';
            }
        }
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