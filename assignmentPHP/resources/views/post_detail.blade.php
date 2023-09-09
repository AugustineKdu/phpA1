@extends('layouts.master')

@section('title', 'Post Detail')

@section('content')
    <div class="container mt-5">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->message }}</p>
        <p><small class="text-muted">Posted by {{ $post->author }} on {{ $post->date }}</small></p>

        <hr>

        <h4>Comments</h4>
        <ul>
            @foreach($comments as $comment)
                <li>{{ $comment->author }}: {{ $comment->message }}</li>
            @endforeach
        </ul>

        <hr>

        <form action="/add-comment/{{ $post->id }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Comment</label>
                <textarea class="form-control" id="message" name="message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    </div>
@endsection
