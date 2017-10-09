<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 09/10/2017
 * Time: 1:43 PM
 */
namespace App\Http\Controllers\Wx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class IndexController extends Controller
{

    function index(Request $request){
        echo $request->input("echostr");
        exit;
    }

    function respondMSG(){
        $postStr = file_get_contents("php://input", 'r');
        if (!empty($postStr)){
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";

            //订阅事件
            if ($postStr->Event == "subscribe") {

                $msgType = "text";
                $contentStr = "欢迎关注!!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);

                echo $resultStr;
            }

            if (! empty($keyword)) {
                $msgType = "text";
                $contentStr = "自动回复 --- 》 " ;  // 判断 是否 是电影 资讯 ！！
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
        }
    }
}
