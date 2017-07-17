@extends('base.base')

@section('title','首页')

@section('content')
    <div class="ling-list-box">
        <ul class="ling-list">
            @foreach($list as $l)
                <li>
                    @if($l->image_url)
                        <div class="ling-img-box">
                            <a target="_blank" href="/article/{{ $l->id }}" class="thumbnail">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').$l->image_url }}">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3 style="font-size: 22px;line-height: 30px; margin: 0; padding: 0;"><a target="_blank" href="/article/{{ $l->id }}">{{ filterTitle($l->id,$l->title) }}</a></h3>
                        <p style="color: #888;height: 48px;overflow: hidden;padding-top: 6px;" >{{ filterAbstract($l->id,$l->abstract) }}</p>
                        <div class="">
                            {{--<a style="float:left; margin-right:30px">作者</a>--}}
                            {{--<a style="float:left; margin-right:30px">{{ $l->name }}</a>--}}
                            <p style="float:left; margin-right:20px; color: black;">{{ $l->name }}</p>
                            <p>{{ format_time($l->create_date) }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div> <!-- ling-list-box -->
    {{ $list->links('vendor/pagination/bootstrap-4') }}
@endsection

@section('js')

@endsection