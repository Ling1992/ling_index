@extends('base.base')

@section('title','首页')

@section('content')
    <div class="ling-list-box">
        <ul class="ling-list">
            <li>
                <div class="ling-img-box">
                    <a href="#" class="thumbnail">
                        <img src="http://localhost:8080/image/timg.jpeg" alt="...">
                    </a>
                </div>
                <div class="ling-txt-box">
                    <h3 style="font-size: 22px;line-height: 30px; margin: 0; padding: 0;"><a href="#">[荐读]这一年，我30岁，孩子3岁</a></h3>
                    <p style="color: #888;height: 48px;overflow: hidden;padding-top: 6px;" >这一年：我30岁，孩子3岁我周围有很多的朋友，还有很多的我喜欢的娱乐活动！我偶尔会觉得，真是为这个小家伙操碎了心！孩子刚刚上幼儿园，看着他小小的坚强的背影，心中又喜悦又有点小小的心酸。离别了一整天，...</p>
                    <div class="">
                        <a style="float:left; margin-right:30px">作者</a>
                        <p>2012-01-01 21:00:00</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="ling-img-box">
                    <a href="#" class="thumbnail">
                        <img src="http://localhost:8080/image/timg.jpeg" alt="..." style="width: 100%; height:100%">
                    </a>
                </div>
                <div class="ling-txt-box">
                    <h3 style="font-size: 22px;line-height: 30px; margin: 0; padding: 0;"><a href="#">[荐读]这一年，我30岁，孩子3岁</a></h3>
                    <p style="color: #888;height: 48px;overflow: hidden;padding-top: 6px;" >这一年：我30岁，孩子3岁我周围有很多的朋友，还有很多的我喜欢的娱乐活动！我偶尔会觉得，真是为这个小家伙操碎了心！孩子刚刚上幼儿园，看着他小小的坚强的背影，心中又喜悦又有点小小的心酸。离别了一整天，...</p>
                    <div class="">
                        <a style="float:left; margin-right:30px">作者</a>
                        <p>2012-01-01 21:00:00</p>
                    </div>
                </div>
            </li>
        </ul>
    </div> <!-- ling-list-box -->
    @include('base.page')
@endsection