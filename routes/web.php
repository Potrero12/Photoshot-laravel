<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// controladores de usuario
Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('configuracion');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
Route::get('gente/{search?}', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/perfil/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');

// controladores de Imagen
Route::get('/upload-image', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.file');
Route::get('/imagen/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');
Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/imagen/editar/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');

// controladores de Comentarios
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/commet/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');

// controladores de like
Route::get('/like/{image_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');
Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');



