@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Recent Posts</h2>

                @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->message }}</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="col-md-4">
                <h2>Recent Comments</h2>
                <!-- 나중에 댓글 데이터도 추가할 수 있습니다 -->
            </div>
        </div>
    </div>
@endsection
