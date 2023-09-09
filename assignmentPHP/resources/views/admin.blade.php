@extends('layouts.master')

@section('title', 'Admin Page')

@section('content')
    <h1>Admin Page</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Message</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Like count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->author }}</td>
                <td>{{ $post->message }}</td>
                <td>{{ $post->date }}</td>

                <td>
                    <ul>
                        @foreach ($comments[$post->id] as $comment)
                            <li>{{ $comment->author }}: {{ $comment->message }}</li>
                        @endforeach
                    </ul>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
