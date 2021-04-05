<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/', 'PostsController@index');

Route::resource('/posts', 'PostsController');
Route::resource('/comments', 'CommentsController');
Route::resource('/categories', 'CategoriesController');
Route::get('users/{user}/posts', 'UsersController@show')->name('users.posts');

Route::middleware(['auth'])->group(function () {
    Route::get('trashed-posts', 'PostsController@trashed')
        ->name('trashed-posts.index');
    Route::put('restore-posts/{post}', 'PostsController@restore')
        ->name('restore-posts');
    Route::get('users/profile', 'UsersController@edit')
        ->name('users.edit-profile');
    Route::put('users/profile', 'UsersController@update')
        ->name('users.update-profile');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/users', 'UsersController@index')
        ->name('users.index');
    Route::delete('/users/{user}', 'UsersController@destroy')
        ->name('users.destroy');
    Route::post('/users/{user}/make-admin', 'UsersController@makeAdmin')
        ->name('users.make-admin');
    Route::post('/users/{user}/make-user', 'UsersController@makeUser')
        ->name('users.make-user');
});
