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
    $posts = DB::select("SELECT Posts.*, Users.username as author, COUNT(DISTINCT Comments.comment_id) as comment_count, COUNT(DISTINCT Likes.like_id) as like_count
                        FROM Posts
                        JOIN Users ON Posts.user_id = Users.user_id
                        LEFT JOIN Comments ON Posts.post_id = Comments.post_id
                        LEFT JOIN Likes ON Posts.post_id = Likes.post_id
                        GROUP BY Posts.post_id, Users.username, Posts.title, Posts.message, Posts.date, Posts.user_id
                        ORDER BY Posts.date DESC");

    return view('home', ['posts' => $posts]);
});

// 포스트 생성
Route::post('/create-post', function (Request $request) {
    $title = $request->input('title');
    $message = $request->input('message');
    $username = $request->input('username');

    // 유저 인증이 필요합니다.
    $users = DB::select("SELECT * FROM Users WHERE username = ?", [$username]);
    $user = $users[0] ?? null;
    $user_id = $user->user_id ?? 1;

    DB::insert("INSERT INTO Posts (title, user_id, message, date) VALUES (?, ?, ?, ?)", [$title, $user_id, $message, now()]);

    return redirect('/');
});

// 좋아요 추가
Route::post('/post/{post_id}/like', function (Request $request, $post_id) {
    $username = $request->input('username');

    // 유저 인증이 필요합니다.
    $users = DB::select("SELECT * FROM Users WHERE username = ?", [$username]);
    $user = $users[0] ?? null;
    $user_id = $user->user_id ?? 1;

    // 해당 포스트에 대해 이 유저가 이미 좋아요를 눌렀는지 확인
    $existingLikes = DB::select("SELECT * FROM Likes WHERE post_id = ? AND user_id = ?", [$post_id, $user_id]);
    $existingLike = $existingLikes[0] ?? null;

    if (!$existingLike) {
        DB::insert("INSERT INTO Likes (post_id, user_id) VALUES (?, ?)", [$post_id, $user_id]);
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

// 유저 기반 검색 기능
Route::get('/search', function (Request $request) {
    $query = $request->input('query');

    if ($query) {
        $users = DB::select("SELECT * FROM Users WHERE username LIKE ?", ['%' . $query . '%']);

        foreach ($users as $user) {
            $user->posts = DB::select("SELECT * FROM Posts WHERE user_id = ?", [$user->user_id]);
            $user->comments = DB::select("SELECT * FROM Comments WHERE user_id = ?", [$user->user_id]);
            $user->likedPosts = DB::select("SELECT Posts.* FROM Posts JOIN Likes ON Posts.post_id = Likes.post_id WHERE Likes.user_id = ?", [$user->user_id]);
        }
    } else {
        $users = [];
    }

    return view('search', ['query' => $query, 'users' => $users]);
});


// 유저 생성 폼
Route::get('/create-user', function () {
    return view('create-user');
});

// 유저 생성 처리
Route::post('/create-user', function (Request $request) {
    $username = $request->input('username');
    $user_id = $request->input('user_id');

    // 유저 중복 체크
    $existingUser = DB::select("SELECT * FROM Users WHERE username = ? OR user_id = ?", [$username, $user_id]);
    if ($existingUser) {
        return redirect('/create-user')->withErrors(['Username or User ID already exists']);
    }

    // 유저 생성
    DB::insert("INSERT INTO Users (username, user_id) VALUES (?, ?)", [$username, $user_id]);

    return redirect('/')->with('message', 'User created successfully');
});

// Admin 로그인 페이지
Route::get('/admin-login', function () {
    return view('admin-login');
});

// Admin 로그인 처리
Route::post('/admin-login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password'); // 실제로는 암호화가 필요합니다.

    // 가정: admin 아이디는 1, 이름은 'admin'
    if ($username === 'admin' && $password === 'admin') {
        $request->session()->put('admin_id', 1);
        $request->session()->put('admin_username', 'admin');
        return redirect('/admin');
    }

    return redirect('/admin-login')->with('error', 'Invalid credentials');
});

// Admin 대시보드
Route::get('/admin', function (Request $request) {
    $admin_id = $request->session()->get('admin_id', null);
    $admin_username = $request->session()->get('admin_username', null);

    if ($admin_id && $admin_username) {
        $users = DB::select("SELECT * FROM Users");
        $posts = DB::select("SELECT * FROM Posts");
        $comments = DB::select("SELECT * FROM Comments");

        return view('admin', ['users' => $users, 'posts' => $posts, 'comments' => $comments]);
    }

    return redirect('/admin-login');
});

// 삭제 라우트 예시
Route::post('/admin/delete-user/{user_id}', function ($user_id) {
    DB::delete("DELETE FROM Users WHERE user_id = ?", [$user_id]);
    return redirect('/admin');
});

Route::post('/admin/delete-post/{post_id}', function ($post_id) {
    DB::delete("DELETE FROM Posts WHERE post_id = ?", [$post_id]);
    return redirect('/admin');
});

Route::post('/admin/delete-comment/{comment_id}', function ($comment_id) {
    DB::delete("DELETE FROM Comments WHERE comment_id = ?", [$comment_id]);
    return redirect('/admin');
});