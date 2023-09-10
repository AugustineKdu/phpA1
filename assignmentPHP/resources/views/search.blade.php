@extends('layouts.master')

@section('title')

@endsection

@section('content')
<h1>Search</h1>

<!-- Search Form -->
<form action="/search" method="GET">
    <div class="form-group">
        <input type="text" name="query" class="form-control" placeholder="Typing Key word">
        <button type="submit" class="btn btn-primary">Find</button>
    </div>
</form>


<h2>Posts</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->author }}</td>
                <td>{{ $post->date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Comments</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Author</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->message }}</td>
                <td>{{ $comment->author }}</td>
                <td>{{ $comment->date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

