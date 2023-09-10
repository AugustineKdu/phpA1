@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5" style="background-color: #343a40;">
        <div class="row">
            <!-- Left 60% section: Recent Posts -->
            <div class="col-md-7 border-right" style="padding: 20px; color: yellow; ">
                <h2 style="font-size: 2.5em;">Recent Posts</h2>

                @foreach($posts as $post)
                    <div class="card mb-3" style="background-color: #f5f5dc; color: #000;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1.8em;"><a style ="color: #0B0B45;" href="{{ url('/post/' . $post->post_id) }}">{{ $post->title }}</a></h5>
                            <p class="card-text" style="font-size: 1.2em;">{{ $post->message }}</p>
                            <p class="card-text">
                                <small style="font-size: 1.2em; color: black;">Posted by {{ $post->author }} on {{ $post->date }}</small><br>
                                <small style="font-size: 1.2em; color: #008000;">Comments: {{ $post->comment_count }}</small>
                                <small style="font-size: 1.2em; color: purple;"> | Likes: {{ $post->like_count }}</small>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Right 40% section: Create New Post Form -->
            <div class="col-md-5" style="padding: 20px; color: #fff;">
                <h2 class="text-success">Create New Post</h2>
                <form action="/create-post" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control form-control-lg" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 btn-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
