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
Route::get('/', function () {
    $posts = DB::table('Posts')->select('id', 'title', 'author', 'message', 'date', 'like_count')->orderBy('date', 'desc')->get();
    $comments = [];
    foreach ($posts as $post) {
        $comments[$post->id] = DB::table('Comments')->where('post_id', $post->id)->get();
    }
    return view('home', ['posts' => $posts, 'comments' => $comments]);
});


Route::post('/like/{post}', function ($postId) {
    $post = DB::table('Posts')->where('id', $postId)->first();

    if ($post) {
        $newLikeCount = ($post->like_count ?? 0) + 1;
        DB::table('Posts')->where('id', $postId)->update(['like_count' => $newLikeCount]);
    }

    return redirect()->back();
});




Route::post('/save-post', function (Request $request) {

    $request->validate([
        'title' => 'required|min:3',
        'author' => 'required|alpha',
        'message' => 'required|min:5',
    ]);


    $title = $request->input('title');
    $author = $request->input('author');
    $message = $request->input('message');
    $date = now();


    DB::insert('INSERT INTO Posts (title, author, message, date) VALUES (?, ?, ?, ?)', [$title, $author, $message, $date]);

    return redirect('/');
});
Route::get('/create-post', function () {
    return view('create_post')->with('status', 'Post created successfully!');
});

Route::get('/post/{id}', function ($id) {
    $post = DB::table('Posts')->where('id', $id)->first();
    $comments = DB::table('Comments')->where('post_id', $id)->get();
    return view('post_detail', ['post' => $post, 'comments' => $comments]);
});

Route::post('/add-comment/{id}', function ($id) {
    $validated = request()->validate([
        'author' => 'required',
        'message' => 'required',
    ]);

    DB::table('Comments')->insert([
        'post_id' => $id,
        'author' => $validated['author'],
        'message' => $validated['message'],
        'date' => now(),
    ]);

    return redirect("/post/{$id}");
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/search_results', function (Request $request) {
    $query = $request->input('query');

    // Search in the Posts table
    $posts = DB::table('Posts')
        ->where('title', 'LIKE', '%' . $query . '%')
        ->orWhere('message', 'LIKE', '%' . $query . '%')
        ->orWhere('author', 'LIKE', '%' . $query . '%')
        ->get();

    // Search in the Comments table
    $comments = DB::table('Comments')
        ->where('message', 'LIKE', '%' . $query . '%')
        ->orWhere('author', 'LIKE', '%' . $query . '%')
        ->get();

    // Pass the search results to the view
    return view('search_results', [
        'posts' => $posts,
        'comments' => $comments,
    ]);
});


Route::get('/test', function () {
    $sqlFilePath = base_path('database/Create_table.sql');


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