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

class IndexController extends Controller
{

    function index(Request $request){
        echo $request->input("echostr");
        exit;
    }

    function respondMSG(){

    }
}
