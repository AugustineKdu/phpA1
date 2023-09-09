<?php

use Illuminate\Http\Request; // Request 클래스 사용을 위한 import
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // DB 파사드 사용을 위한 import
use Illuminate\Support\Facades\File; // File 파사드 사용을 위한 import

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
Route::get('/', function () {
    $posts = DB::select('SELECT * FROM Posts ORDER BY date DESC');
    $comments = [];
    foreach ($posts as $post) {
        $comments[$post->id] = DB::select('SELECT * FROM Comments WHERE post_id = ?', [$post->id]);
    }
    return view('home', ['posts' => $posts, 'comments' => $comments]);
});


Route::get('/create-post', function () {
    return view('create_post');
});

Route::post('/save-post', function (Request $request) {
    // 입력값 검증
    $request->validate([
        'title' => 'required|min:3',
        'author' => 'required|alpha',
        'message' => 'required|min:5',
    ]);

    // 입력값 가져오기
    $title = $request->input('title');
    $author = $request->input('author');
    $message = $request->input('message');
    $date = now();

    // 데이터베이스에 저장
    DB::insert('INSERT INTO Posts (title, author, message, date) VALUES (?, ?, ?, ?)', [$title, $author, $message, $date]);

    return redirect('/')->with('status', 'Post created successfully!');
});

Route::get('/test', function () {
    $sqlFilePath = base_path('database/Create_table.sql'); // 파일 경로를 정확하게 지정해야 합니다.

    // 파일이 존재하는지 확인
    if (File::exists($sqlFilePath)) {
        $contents = File::get($sqlFilePath);
        return response($contents, 200)
            ->header('Content-Type', 'text/plain');
    }

    return response("File does not exist.", 404);
});

Route::get('/admin', function () {
    $posts = DB::select('SELECT * FROM Posts');
    $comments = [];
    foreach ($posts as $post) {
        $comments[$post->id] = DB::select('SELECT * FROM Comments WHERE post_id = ?', [$post->id]);
    }
    return view('admin', ['posts' => $posts, 'comments' => $comments]);
});