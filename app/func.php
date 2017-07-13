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
    \Illuminate\Support\Facades\Log::info('1111');
    $format = [
        'between_one_minute' => '刚刚',
        'before_minute'      => '分钟前',
        'after_minute'       => '分钟后',
        'today'              => 'H:i',
        'yesterday'          => '昨天 H:i',
        'tomorrow'           => '明天 H:i',
        'default'            => 'n月d日 H:i',
        'diff_year'             => 'Y年n月d日 H:i',
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

    $now = \Carbon\Carbon::now();

    //今天
    if( $dt->isToday() ) {

        $diff_minute = floor(abs($now->timestamp - $dt->timestamp) / 60);
        $diff_second = $now->timestamp - $dt->timestamp;

        //一小时内
        if($diff_minute < 60) {

            //一分钟内
            if($diff_second < 60 && $diff_second >= 0) return $format['between_one_minute'];

            return $diff_second < 0 ? $diff_minute.$format['after_minute'] : $diff_minute.$format['before_minute'] ;
        }

        return $dt->format($format['today']);
    }

    //昨天
    if( $dt->isYesterday() ) return $dt->format($format['yesterday']);

    //明天
    if( $dt->isTomorrow() ) return $dt->format($format['tomorrow']);

    //非今年，其他时间
    if( $dt->format('Y') !== $now->format('Y') ) return $dt->format($format['diff_year']);

    //今年，其他时间
    return $dt->format($format['default']);

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
    foreach ($this->ling as $v) {
        if ($v == '') continue;
        if(strpos($str,$v)!==false ){
            $str = str_replace($v,str_pad('',mb_strlen($v),'*'),$str);
        }
    }
    return $str;
}
function filterContent($content) {
    $content = filterKey($content);
    $content = preg_replace('/data-src="([^"]+)/i', 'src="/static/theme1/img/blank.gif" data-echo="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=\1', $content);
    // $content = str_replace(['data-src'], ['src'], $content);
    return strip_tags($content, "<p><img><iframe>");
}