@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- 왼쪽 60% 영역: 최근 포스트 -->
            <div class="col-md-7">
                <h2>Recent Posts</h2>

                @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><a href="{{ url('/post/' . $post->post_id) }}">{{ $post->title }}</a></h5>
                            <p class="card-text">{{ $post->message }}</p>
                            <p class="card-text">
                                <small class="text-muted">Posted by {{ $post->author }} on {{ $post->date }}</small><br>
                                <small class="text-muted">Comments: {{ $post->comment_count }} | Likes: {{ $post->like_count }}</small>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 오른쪽 40% 영역: 새 포스트 입력 폼 -->
            <div class="col-md-5">
                <h2>Create New Post</h2>
                <form action="/create-post" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
