@extends('base.base')

@section('title','首页')

@section('content')

    <div class="blog-post" style="position: relative">
        <h2 class="blog-post-title">{{ $data->title }}</h2>
        <p class="blog-post-meta"> {{ $data->create_date }} </p>
        <div style="position: relative">
            <div style="display: block;">
                {!! $data->article !!}
            </div>
        </div>
    </div><!-- /.blog-post -->

@endsection

@section('js')

@endsection