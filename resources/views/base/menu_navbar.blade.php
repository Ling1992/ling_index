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
                    <a class="navbar-brand" href="/">资讯 &bull; V-宝典</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        @foreach ($category_menu as $k=>$v)
                            @if ($loop->iteration > 3)
                                @break
                            @endif
                            <li @if($category == $k)
                                    class="active"
                                    @endif
                                    ><a href="/category/{{ $k }}">{{ $v }}</a></li>
                        @endforeach

                        @if (count($category_menu) >= 3 )
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($category_menu as $k=>$v)
                                        @if ($loop->iteration > 3)
                                            @if (($loop->iteration % 3) == 0)
                                                <li role="separator" class="divider"></li>
                                            @endif
                                            <li @if($category == $k)
                                                    class="active"
                                                    @endif
                                            ><a href="/category/{{ $k }}">{{ $v }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
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