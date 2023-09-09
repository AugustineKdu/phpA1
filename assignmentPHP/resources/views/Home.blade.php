@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Recent Posts</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Post Title 1</h5>
                        <p class="card-text">This is a sample post content. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Post Title 2</h5>
                        <p class="card-text">This is another sample post content. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Recent Comments</h2>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
