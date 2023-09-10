@extends('layouts.master')

@section('navbar-title', 'Post Detail')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- 포스트 정보 -->
        <div class="col-md-6">
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->message }}</p>
    <small>Posted by {{ $post->author }} on {{ $post->date }}</small>
    <p>Comments: {{ $comment_count }} | Likes: {{ $like_count }}</p>
    <!-- 코멘트 섹션 -->
    <h2>Comments</h2>
            @foreach($comments as $comment)
                <p>{{ $comment->message }} ({{ $comment->commenter }})</p>
            @endforeach
    </div>

        <!-- 좋아요 및 코멘트 -->
        <div class="col-md-6">
            <!-- 좋아요 버튼 -->
            <form action="/post/{{ $post->post_id }}/like" method="POST">
            <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                @csrf
                <button type="submit" class="btn btn-success mt-2 mb-4">Like</button>
            </form>



            <!-- 코멘트 작성 폼 -->
            <form action="/post/{{ $post->post_id }}/comment" method="POST">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="message">New Comment</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
@endsection
