@extends('layouts.master')

@section('navbar-title', 'Search ')

@section('content')
<div class="container mt-5" style="color: #FFFFFF;">
    <h2>Search User</h2>
    <form action="/search" method="GET">
        <input type="text" name="query" placeholder="Search by username">
        <button type="submit">Search</button>
    </form>

    @if(isset($query))
        <table class="table mt-5" style="color: #FFFFFF;">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Posts</th>
                    <th>Comments</th>
                    <th>Liked Posts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>
                            @foreach($user->posts as $post)
                                {{ $post->title }} ({{ $post->date }})
                            @endforeach
                        </td>
                        <td>
                            @foreach($user->comments as $comment)
                                {{ $comment->message }} ({{ $comment->date }})
                            @endforeach
                        </td>
                        <td>
                            @foreach($user->likedPosts as $likedPost)
                                {{ $likedPost->title }}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No search query entered.</p>
    @endif
</div>
@endsection
