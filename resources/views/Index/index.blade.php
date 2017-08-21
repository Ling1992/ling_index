@extends('base.base')

@section('title','首页')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-ling">
        <li><a href="/">首页</a></li>
        <li class="active">{{ $category_name }}</li>
    </ol>
@endsection
@section('content')
    <div class="ling-list-box">
        <ul class="ling-list">
            @foreach($list as $l)
                <li>
                    @if($l->image_url)
                        <div class="ling-img-box">
                            <a href="/article/{{ $l->id }}">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($l->image_url) }}" style="background:#ccc  no-repeat center center" class="img-rounded">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3><a class="btn-link" href="/article/{{ $l->id }}">{{ filterTitle($l->id,$l->title) }}</a></h3>
                        <p class="abstract">{{ filterAbstract($l->id,$l->abstract) }}</p>
                        <div class="tips">
                            <p style="float:left; margin-right:10px">
                                {{--<a >作者</a>--}}
                            </p>
                            {{--<a style="float:left; margin-right:30px">{{ $l->name }}</a>--}}
                            <p style="float:left; margin-right:10px; color: black;">{{ $l->name }}</p>
                            <p style="float: left; margin-right:10px;">{{ format_time($l->create_date) }}</p>
                            {{--<p style="float: left;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 1213</p>--}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div> <!-- ling-list-box -->
    <div>
        {{ $list->links('vendor/pagination/bootstrap-4') }}
    </div>
@endsection

@section('js')

@endsection