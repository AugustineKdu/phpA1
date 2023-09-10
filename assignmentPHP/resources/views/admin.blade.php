@extends('layouts.master')

@section('navbar-title', 'Admin Dashboard')

@section('content')
<div class="container mt-5" style="color: #FFFFFF;">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- User List -->
    <h2>Users</h2>
    <table class="table" style="color: #FFFFFF;">
        <thead>
            <tr>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>
                    <form method="POST" action="/admin/delete-user/{{ $user->user_id }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Post list -->
    <h2>Posts</h2>
    <table class="table" style="color: #FFFFFF;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>
                    <form method="POST" action="/admin/delete-post/{{ $post->post_id }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Comment List -->
    <h2>Comments</h2>
    <table class="table" style="color: #FFFFFF;">
        <thead>
            <tr>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->message }}</td>
                <td>
                    <form method="POST" action="/admin/delete-comment/{{ $comment->comment_id }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
