<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

// Home screen
Route::get('/', function () {
    // Fetch all posts along with author information
    $posts = DB::select("SELECT Posts.*, Users.username as author,
                        COUNT(DISTINCT Comments.comment_id) as comment_count,
                        COUNT(DISTINCT Likes.like_id) as like_count
                        FROM Posts
                        JOIN Users ON Posts.user_id = Users.user_id
                        LEFT JOIN Comments ON Posts.post_id = Comments.post_id
                        LEFT JOIN Likes ON Posts.post_id = Likes.post_id
                        GROUP BY Posts.post_id, Users.username, Posts.title, Posts.message, Posts.date, Posts.user_id
                        ORDER BY Posts.date DESC");

    return view('home', ['posts' => $posts]);
});


// Section: Posts Management

// Create a post
Route::post('/create-post', function (Request $request) {
    // Input validation
    $title = htmlentities($request->input('title'));
    $message = htmlentities($request->input('message'));
    $username = htmlentities($request->input('username'));

    if (empty($title) || empty($message) || empty($username)) {
        return redirect('/')->with('error', 'All fields are required');
    }

    // Fetch user ID
    $user = DB::select("SELECT * FROM Users WHERE username = ?", [$username]);
    $user_id = $user[0]->user_id ?? 1;

    // Insert the post
    DB::insert("INSERT INTO Posts (title, user_id, message, date) VALUES (?, ?, ?, ?)", [$title, $user_id, $message, now()]);

    return redirect('/');
});

// Add a comment
Route::post('/post/{post_id}/comment', function (Request $request, $post_id) {
    // Input validation
    $message = htmlentities($request->input('message'));
    $username = htmlentities($request->input('username'));

    if (empty($message) || empty($username)) {
        return redirect("/post/{$post_id}")->with('error', 'All fields are required');
    }

    // Fetch user ID
    $user = DB::table('Users')->where('username', $username)->first();

    if ($user) {
        $user_id = $user->user_id;

        // Insert the comment
        DB::table('Comments')->insert([
            'post_id' => $post_id,
            'user_id' => $user_id,
            'message' => $message,
            'date' => now()
        ]);

        return redirect("/post/{$post_id}");
    } else {
        return redirect("/post/{$post_id}")->with('error', 'User not found');
    }
});


// Add a like
Route::post('/post/{post_id}/like', function (Request $request, $post_id) {
    // Fetch user ID
    $username = htmlentities($request->input('username'));
    $user = DB::select("SELECT * FROM Users WHERE username = ?", [$username]);
    $user_id = $user[0]->user_id ?? 1;

    // Check for existing like by the user on the post
    $existingLike = DB::select("SELECT * FROM Likes WHERE post_id = ? AND user_id = ?", [$post_id, $user_id]);

    if (!$existingLike) {
        // Insert the like
        DB::insert("INSERT INTO Likes (post_id, user_id) VALUES (?, ?)", [$post_id, $user_id]);
    }

    return redirect("/post/{$post_id}");
});

// Post detail page
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

// User search functionality
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

// User creation form
Route::get('/create-user', function () {
    return view('create-user');
});

// User creation processing
Route::post('/create-user', function (Request $request) {
    $username = $request->input('username');
    $user_id = $request->input('user_id');

    // User duplication check
    $existingUser = DB::select("SELECT * FROM Users WHERE username = ? OR user_id = ?", [$username, $user_id]);
    if ($existingUser) {
        return redirect('/create-user')->withErrors(['Username or User ID already exists']);
    }

    // Create user
    DB::insert("INSERT INTO Users (username, user_id) VALUES (?, ?)", [$username, $user_id]);

    return redirect('/')->with('message', 'User created successfully');
});

// Admin login page
Route::get('/admin-login', function () {
    return view('admin-login');
});

// Admin login processing
Route::post('/admin-login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password'); // In practice, encryption is needed.

    // Assumption: admin ID is 1, and the name is 'admin'.
    if ($username === 'admin' && $password === 'admin') {
        $request->session()->put('admin_id', 1);
        $request->session()->put('admin_username', 'admin');
        return redirect('/admin');
    }

    return redirect('/admin-login')->with('error', 'Invalid credentials');
});

// Admin dashboard
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

// Delete routes example
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