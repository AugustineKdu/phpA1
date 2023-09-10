@extends('layouts.master')

@section('navbar-title', 'Admin Dashboard')

@section('content')
<!-- Admin login form -->
<form method="POST" action="/admin-login">
    @csrf
    <label for="username">Username</label>
    <input type="text" id="username" name="username">

    <label for="password">Password</label>
    <input type="password" id="password" name="password">

    <button type="submit">Login</button>
</form>


@endsection
