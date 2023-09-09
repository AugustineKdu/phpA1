@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Recent Posts</h2>

                @foreach($posts as $post)
                    <div class="card mb-3 clickable" onclick="window.location='/post/{{ $post->id }}';">
                        <div class="card-body">
                           <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->message }}</p>
                            <p class="card-text"><small class="text-muted">Posted by {{ $post->author }} on {{ $post->date }}</small></p>
                            <p class="card-text">Total Comments: {{ count($comments[$post->id]) }}</p>
                            <!-- Here is where we display the like count -->
                            <p class="card-text">Likes: {{ $post->like_count ?? '0' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
