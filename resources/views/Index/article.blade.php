@extends('base.base')

@section('title')
    {{ filterTitle($data->id,$data->title) }}
    -
    @parent
@endsection


@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-ling">

        @if($category && $category != 'new')
            <li><a href="/">首页</a></li>
            <li><a href="/category/{{ $category }}">{{ $category_list[$category] }}</a></li>
            <li class="active">正文</li>
        @else
            <li><a href="/">首页</a></li>
            <li class="active">正文</li>
        @endif
    </ol>
@endsection


@section('content')

    <div class="blog-post" style="position: relative">
        <h2 class="blog-post-title">{{ filterTitle($data->id,$data->title) }}</h2>
        <p class="blog-post-meta"> {{ $data->create_date }} </p>
        <div style="position: relative">
            <div style="display: block;">
                {!! $data->article !!}
            </div>
        </div>
    </div><!-- /.blog-post -->

    <div style="margin-top: 50px; background-color: #b0b0b0; padding: 20px">
        <h3>阅读推荐</h3>
    </div>
    <div class="ling-list-box">
        <ul class="ling-list">
            @foreach($recommendation as $l)
                <li>
                    @if($l->image_url)
                        <div class="ling-img-box">
                            <a href="/article/{{ $l->id }}" class="thumbnail">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($l->image_url) }}" style="background:#ccc  no-repeat center center">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3><a class="btn-link" href="/article/{{ $l->id }}">{{ filterTitle($l->id,$l->title) }}</a></h3>
                        <p class="abstract">{{ filterAbstract($l->id,$l->abstract) }}</p>
                        <div class="tips">
                            {{--<a style="float:left; margin-right:30px">作者</a>--}}
                            {{--<a style="float:left; margin-right:30px">{{ $l->name }}</a>--}}
                            {{--<p style="float:left; margin-right:20px; color: black;">{{ $l->name }}</p>--}}
                            <p style="float: left">{{ format_time($l->create_date) }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div> <!-- ling-list-box -->

@endsection

@section('js')

@endsection