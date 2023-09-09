<?php

use Illuminate\Support\Facades\Route;

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
    $posts = DB::select("SELECT * FROM Posts ORDER BY date DESC");

    return view('home', ['posts' => $posts]);
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