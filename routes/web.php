<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mypage', function () {
    return view('mypage');
})->middleware('auth');

Route::get('/top', function () {
    return view('top');
});

//アカウント登録画面
Route::get('/auth', [App\Http\Controllers\AuthController::class, 'index'])->name('auth.index');
//アカウント登録処理
Route::post('/auth/create', [App\Http\Controllers\AuthController::class, 'create'])->name('auth.create');
//アカウント仮登録確認画面
Route::get('/auth/create-tmp-verify', [App\Http\Controllers\AuthController::class, 'createTmpVerify'])->name('auth.create.tmp.verify');
//アカウント登録確認画面
Route::get('/auth/create-verify/{token}', [App\Http\Controllers\AuthController::class, 'createVerify'])->name('auth.create.verify');
//パスワードリセット画面
Route::get('/auth/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('auth.reset.password');
//パスワード再登録メール送信処理
Route::post('/auth/send-reset-password-email', [App\Http\Controllers\AuthController::class, 'sendResetPasswordEmail'])->name('auth.send.reset.password.email');
//パスワード登録画面
Route::get('/auth/create-password/{token}', [App\Http\Controllers\AuthController::class, 'createPassword'])->name('auth.create.password');
//パスワード登録確認画面
Route::post('/auth/create-password-verify/{token}', [App\Http\Controllers\AuthController::class, 'createPasswordVerify'])->name('auth.create.password.verify');
//ログイン画面
Route::get('/auth/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
//ログイン処理
Route::post('/auth/signin', [App\Http\Controllers\AuthController::class, 'signin'])->name('auth.signin');
//ログアウト処理
Route::get('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
