
<div class="sidebar-module sidebar-module-inset">
    <h4>阅读推荐</h4>
    <ol class="list-unstyled">
        @foreach($recommendation as $r)
            <li class="row">
                @if($r->image_url)
                    <div class="col-sm-4" style="padding: 0;margin: 0">
                        <a target="_blank" href="/article/{{ $r->id }}" class="thumbnail">
                            <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').$r->image_url }}">
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <span><a target="_blank" href="/article/{{ $r->id }}">{{ filterTitle($r->id,$r->title) }}</a></span>
                        <div class="">
                            <p>{{ format_time($r->create_date) }}</p>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <span><a target="_blank" href="/article/{{ $r->id }}">{{ filterTitle($r->id,$r->title) }}</a></span>
                        <div class="">
                            <p>{{ format_time($r->create_date) }}</p>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</div>
{{--<div class="sidebar-module">--}}
    {{--<h4>相关文章</h4>--}}
    {{--<ol class="list-unstyled">--}}
        {{--<li><a href="#">March 2014</a></li>--}}
        {{--<li><a href="#">February 2014</a></li>--}}
        {{--<li><a href="#">January 2014</a></li>--}}
        {{--<li><a href="#">December 2013</a></li>--}}
        {{--<li><a href="#">November 2013</a></li>--}}
        {{--<li><a href="#">October 2013</a></li>--}}
        {{--<li><a href="#">September 2013</a></li>--}}
        {{--<li><a href="#">August 2013</a></li>--}}
        {{--<li><a href="#">July 2013</a></li>--}}
        {{--<li><a href="#">June 2013</a></li>--}}
        {{--<li><a href="#">May 2013</a></li>--}}
        {{--<li><a href="#">April 2013</a></li>--}}
    {{--</ol>--}}
{{--</div>--}}
