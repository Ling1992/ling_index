<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="57 point">
    <meta name="author" content="ling">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('bootstrap/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('bootstrap/base.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="{{ asset('bootstrap/assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('bootstrap/assets/js/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="navbar-wrapper">
    <div class="container ling-container">
        <nav class="navbar navbar-default navbar-static-top ling-navbar">
            <div class="container ling-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">最新</a></li>
                        <li><a href="#">搞笑</a></li>
                        <li><a href="#">娱乐</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">商业</a></li>
                                <li><a href="#">数码</a></li>
                                <li><a href="#">感情</a></li>
                                <li role="separator" class="divider"></li>
                                {{--<li class="dropdown-header">Nav header</li>--}}
                                <li><a href="#">三农</a></li>
                                <li><a href="#">汽车</a></li>
                                <li><a href="#">美女</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="./">反馈 <span class="sr-only">(current)</span></a></li>
                        <li><a href="#"> </a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div> <!-- container -->
</div> <!-- navbar-wrapper -->

<div class="container ling-container">

    <div class="row">

        <div class="col-sm-8">
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

            <nav>
                <ul class="pager">
                    <li><a href="#">Previous</a></li>
                    <li><a href="#">Next</a></li>
                </ul>
            </nav>

        </div> <!-- article_list -main -->

        <div class="col-sm-3 col-sm-offset-1">
            <div class="sidebar-module sidebar-module-inset">
                <h4>About</h4>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
            </div>
            <div class="sidebar-module">
                <h4>Archives</h4>
                <ol class="list-unstyled">
                    <li><a href="#">March 2014</a></li>
                    <li><a href="#">February 2014</a></li>
                    <li><a href="#">January 2014</a></li>
                    <li><a href="#">December 2013</a></li>
                    <li><a href="#">November 2013</a></li>
                    <li><a href="#">October 2013</a></li>
                    <li><a href="#">September 2013</a></li>
                    <li><a href="#">August 2013</a></li>
                    <li><a href="#">July 2013</a></li>
                    <li><a href="#">June 2013</a></li>
                    <li><a href="#">May 2013</a></li>
                    <li><a href="#">April 2013</a></li>
                </ol>
            </div>
            <div class="sidebar-module">
                <h4>Elsewhere</h4>
                <ol class="list-unstyled">
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ol>
            </div>
        </div><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->

<div class="container">
    @include('base.footer')
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://lib.sinaapp.com/js/jquery/1.12.4/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery.min.js') }}"><\/script>')</script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('bootstrap/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
</body>
</html>
