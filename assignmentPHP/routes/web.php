<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Home Route



// 홈 화면
Route::get('/', function () {
    $posts = DB::table('Posts')
        ->join('Users', 'Posts.user_id', '=', 'Users.user_id')
        ->leftJoin('Comments', 'Posts.post_id', '=', 'Comments.post_id')
        ->leftJoin('Likes', 'Posts.post_id', '=', 'Likes.post_id')
        ->select('Posts.*', 'Users.username as author', DB::raw('count(distinct Comments.comment_id) as comment_count'), DB::raw('count(distinct Likes.like_id) as like_count'))
        ->groupBy('Posts.post_id', 'Users.username', 'Posts.title', 'Posts.message', 'Posts.date', 'Posts.user_id')
        ->orderBy('Posts.date', 'desc')
        ->get();

    return view('home', ['posts' => $posts]);
});


// 포스트 생성
Route::post('/create-post', function (Request $request) {
    $title = $request->input('title');
    $message = $request->input('message');
    $username = $request->input('username');

    // 유저 인증이 필요합니다.
    $user = DB::table('Users')->where('username', $username)->first();
    $user_id = $user->user_id ?? 1;

    DB::table('Posts')->insert([
        'title' => $title,
        'user_id' => $user_id,
        'message' => $message,
        'date' => now()
    ]);

    return redirect('/');
});

// 포스트 상세 보기
Route::get('/post/{post_id}', function ($post_id) {
    $post = DB::table('Posts')
        ->join('Users', 'Posts.user_id', '=', 'Users.user_id')
        ->where('Posts.post_id', $post_id)
        ->select('Posts.*', 'Users.username as author')
        ->first();

    $comments = DB::table('Comments')
        ->join('Users', 'Comments.user_id', '=', 'Users.user_id')
        ->where('Comments.post_id', $post_id)
        ->select('Comments.*', 'Users.username as commenter')
        ->get();

    return view('post-detail', ['post' => $post, 'comments' => $comments]);
});

// 좋아요 추가
Route::post('/post/{post_id}/like', function (Request $request, $post_id) {
    $username = $request->input('username');

    // 유저 인증이 필요합니다.
    $user = DB::table('Users')->where('username', $username)->first();
    $user_id = $user->user_id ?? 1;

    // 해당 포스트에 대해 이 유저가 이미 좋아요를 눌렀는지 확인
    $existingLike = DB::table('Likes')
        ->where('post_id', $post_id)
        ->where('user_id', $user_id)
        ->first();

    if (!$existingLike) {
        DB::table('Likes')->insert([
            'post_id' => $post_id,
            'user_id' => $user_id
        ]);
    }

    return redirect("/post/{$post_id}");
});

// 코멘트 추가
Route::post('/post/{post_id}/comment', function (Request $request, $post_id) {
    $message = $request->input('message');
    $username = $request->input('username');

    // 유저 인증이 필요합니다.
    $user = DB::table('Users')->where('username', $username)->first();
    $user_id = $user->user_id ?? 1;


    DB::table('Comments')->insert([
        'post_id' => $post_id,
        'user_id' => $user_id,
        'message' => $message,
        'date' => now()
    ]);

    return redirect("/post/{$post_id}");
});

Route::get('/post/{post_id}', function ($post_id) {
    $post = DB::table('Posts')
        ->join('Users', 'Posts.user_id', '=', 'Users.user_id')
        ->where('Posts.post_id', $post_id)
        ->select('Posts.*', 'Users.username as author')
        ->first();

    $comments = DB::table('Comments')
        ->join('Users', 'Comments.user_id', '=', 'Users.user_id')
        ->where('Comments.post_id', $post_id)
        ->select('Comments.*', 'Users.username as commenter')
        ->get();

    $comment_count = DB::table('Comments')
        ->where('post_id', $post_id)
        ->count();

    $like_count = DB::table('Likes')
        ->where('post_id', $post_id)
        ->count();

    if (!$post) {
        return abort(404, 'Post not found');
    }

    return view('post-detail', [
        'post' => $post,
        'comments' => $comments,
        'comment_count' => $comment_count,
        'like_count' => $like_count
    ]);
});

Route::get('/search', function (Request $request) {
    $query = $request->input('query');

    $posts = DB::table('Posts')->where('title', 'LIKE', '%' . $query . '%')->get();
    $users = DB::table('Users')->where('username', 'LIKE', '%' . $query . '%')->get();
    $comments = DB::table('Comments')->where('message', 'LIKE', '%' . $query . '%')->get();
    $likedPosts = DB::table('Likes')
        ->join('Posts', 'Likes.post_id', '=', 'Posts.id')
        ->where('Posts.title', 'LIKE', '%' . $query . '%')
        ->select('Posts.title')
        ->get();

    return view('search', [
        'posts' => $posts,
        'users' => $users,
        'comments' => $comments,
        'likedPosts' => $likedPosts
    ]);
});