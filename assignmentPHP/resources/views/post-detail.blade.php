@extends('layouts.master')

@section('navbar-title', 'Post Detail')

@section('content')
<div class="container mt-5">
    <div class="row">

        <!-- Post Information -->
    <div class="col-md-6" style="border: 2px solid #f5f5dc; padding: 20px; margin-bottom: 20px; background-color: #f5f5dc; border-radius: 15px;">
        <h2 style="color: #0b0b45;">{{ $post->title }}</h2>
        <p style="text-align: left; padding: 10px; color: #0b0b45;">{{ $post->message }}</p>
        <p style="text-align: left; padding: 10px; color: #0b0b45;">Posted by {{ $post->author }} on {{ $post->date }}</p>
        <p style="text-align: left; padding: 10px; color: #0b0b45;">Comments: {{ $comment_count }} | Likes: {{ $like_count }}</p>
            <!-- Comment Section -->
        <h2 style="color: #0b0b45;">Comments</h2>
        <div style="border: 1px solid #f5f5dc; padding: 10px;  border-radius: 10px;">
                @foreach($comments as $comment)
                    <div style="border: 1px solid #f5f5dc; margin: 10px; padding: 10px; background-color: #FAD02E; border-radius: 10px;">
                        <p style="text-align: left; color: #0b0b45;">({{ $comment->commenter }}):  ----- {{ $comment->message }} ----- </p>
                    </div>
                @endforeach
        </div>
    </div>


        <!-- Like and Comment -->
        <div class="col-md-6" style="padding: 20px; margin-top: 20px;">
    <!-- Like Button -->
    <form action="/post/{{ $post->post_id }}/like" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="username" style="color: #FFFF00;">Username</label>
            <input type="text" class="form-control form-control-lg" id="username" name="username" required>
        </div>
        <button type="submit" class="btn btn-success btn-lg mt-2 mb-4">Like</button>
    </form>

    <!-- Comment Form -->
    <form action="/post/{{ $post->post_id }}/comment" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="username" style="color: #FFFF00;">Username</label> <
            <input type="text" class="form-control form-control-lg" id="username" name="username" required>
        </div>
        <div class="form-group mb-3">
            <label for="message" style="color: #FFFF00;">New Comment</label>
            <textarea class="form-control form-control-lg" id="message" name="message" rows="4" required></textarea>
        <button type="submit" class="btn btn-primary btn-lg mt-2">Submit Comment</button>
        </form>
    </div>

    </div>
</div>
@endsection
