@extends('layouts.master')

@section('title', 'Search Results')

@section('content')
<div class="container mt-5">
    <h2>Search</h2>
    <form action="/search" method="GET">
        <input type="text" name="query" placeholder="Search">
        <button type="submit">Search</button>
    </form>

    <div class="row mt-5">
        <div class="col-md-3">
            <h3>Matching Posts</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <h3>Matching Users</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <h3>Matching Comments</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <h3>Liked Posts</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($likedPosts as $likedPost)
                        <tr>
                            <td>{{ $likedPost->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
