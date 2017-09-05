<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 23/06/2017
 * Time: 3:27 PM
 */
/**
 * 格式化时间
 *  mixed \Carbon\Carbon $dt / Int $timestamp / String $date / String "now"
 *  date
 */

function format_time($dt=0)
{
    $format = [
        'between_one_minute' => '刚刚',
        'before_minute'      => '分钟前',
        'before_hours'      => '小时前',
        'before_day'      => '天前',
        'before_month'      => '月前',
        'default'            => 'n月d日 H:i',
        'month_day'            => 'n月d日',
        'diff_year_date'             => 'Y年n月d日 H:i',
        'year'             => 'Y年',
        'error'                 => '时间显示错误'
    ];

    //创建对象
    if( is_int($dt) ) {

        $dt = Carbon\Carbon::createFromTimestamp($dt);

    } else if( ! $dt instanceof \Carbon\Carbon) {
        //错误时间
        if( $dt == '0000-00-00 00:00:00' || $dt === '0' ) return $format['error'];

        $dt = new Carbon\Carbon($dt);
    }
//    return $dt->format($format['diff_year_date']);
    //今天
    $diff_second = abs ($dt->diffInSeconds() );
    $diff_minute = floor($diff_second / 60);
    $diff_hour = floor($diff_minute / 60);

    if( $diff_hour < 24 ) {

        //1小时内
        if($diff_minute < 60) {

            //一分钟内
            if($diff_second < 60) return $format['between_one_minute'];

            return $diff_minute.$format['before_minute'] ;
        }else {


            return $diff_hour . $format['before_hours'];
        }
    }
    $diff_day = ceil($diff_hour / 24);
    if ($dt->isCurrentMonth()) {
        return $diff_day . $format['before_day'];
    }
    if ($dt->isCurrentYear()) {
        return $dt->format($format['month_day']);
    }

    return $dt->format($format['year']);

}

function filterKey($str){

    $arr = \Illuminate\Support\Facades\Cache::get('key_arr');
    if (!$arr) {
        ## 读取关键字文本
        $content = @file_get_contents(base_path('kwd.txt'));
        // 转换成数组
        $arr = explode("\n", $content);
        \Illuminate\Support\Facades\Cache::put('key_arr',$arr,60*24*2);
    }
    foreach ($arr as $v) {
        if ($v == '') continue;
        if(strpos($str,$v)!==false ){
            $str = str_replace($v,str_pad('',mb_strlen($v),'*'),$str);
        }
    }
    return $str;
}
function filterContent($content) {
    $content = preg_replace('/src="([^"]+)/i', 'src="'.asset('img/onload.gif').'" data-echo="'.env('img_src_pre','').'\1', $content);
    $content = filterKey($content);
    // $content = str_replace(['data-src'], ['src'], $content);
    return strip_tags($content, "<p><img><iframe>");
}

function filterTitle($id, $content){
    $title = $content;
    if ($content) {
        $title = \Illuminate\Support\Facades\Cache::get('title_'.$id);
        if (!$title) {
            $title = filterKey($content);
            \Illuminate\Support\Facades\Cache::put('title_'.$id,$title,60*24*2);
        }
    }
    return $title;
}

function filterAbstract($id, $content) {
    $abstract = $content;
    if ($content) {
        $abstract = \Illuminate\Support\Facades\Cache::get('abstract_'.$id);
        if (!$abstract) {
            $abstract = filterKey($content);
            \Illuminate\Support\Facades\Cache::put('abstract_'.$id,$abstract,60*24*2);
        }
    }
    return $abstract;
}

function filterArticle($id, $content) {
    $article = $content;
    if ($content) {
        $article = \Illuminate\Support\Facades\Cache::get('article_'.$id);
        if (!$article) {
            $article = filterContent(htmlspecialchars_decode($content));
            \Illuminate\Support\Facades\Cache::put('article_'.$id,$article,60*24*2);
        }
    }
    return $article;
}

function urlFilter($url, $type=0){
    if (strpos($url,'//') === 0) {
        return "http:".$url;
    }
    return $url;
}