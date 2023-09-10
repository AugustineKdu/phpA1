@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5 bg-light">  <!-- 배경색을 light로 설정 -->
        <div class="row">
            <!-- Left 60% section: Recent Posts -->
            <div class="col-md-7 border-right" style="padding: 20px;">  <!-- 선으로 분리 -->
                <h2 class="text-primary">Recent Posts</h2>  <!-- 글씨 크기 변경 -->

                @foreach($posts as $post)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ url('/post/' . $post->post_id) }}">{{ $post->title }}</a></h5>
                            <p class="card-text text-muted">{{ $post->message }}</p>  <!-- 글씨 크기 변경 -->
                            <p class="card-text">
                                <small class="text-muted">Posted by {{ $post->author }} on {{ $post->date }}</small><br>
                                <small class="text-muted">Comments: {{ $post->comment_count }} | Likes: {{ $post->like_count }}</small>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right 40% section: Create New Post Form -->
            <div class="col-md-5" style="padding: 20px;">
                <h2 class="text-success">Create New Post</h2>  <!-- 글씨 크기 변경 -->
                <form action="/create-post" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" required>  <!-- 폼 스타일 변경 -->
                    </div>
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" required>  <!-- 폼 스타일 변경 -->
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control form-control-lg" id="message" name="message" rows="4" required></textarea>  <!-- 폼 스타일 변경 -->
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 btn-lg">Submit</button>  <!-- 버튼 스타일 변경 -->
                </form>
            </div>
        </div>
    </div>
@endsection
