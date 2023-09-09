@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Recent Posts</h2>

                @foreach($posts as $post)
                    <div class="card mb-3">
                        <div class="card-body">

                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->message }}</p>
                            <p class="card-text"><small class="text-muted">Posted by {{ $post->author }} on {{ $post->date }}</small></p>

                            <h6>Comments:</h6>
                            <ul>
                                @foreach($comments[$post->id] as $comment)
                                    <li>{{ $comment->author }}: {{ $comment->message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
