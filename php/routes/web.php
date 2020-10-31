<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', 'AuthController@logout');

// start page
Route::get('/', function () {
    if (!session()->has('data')) {
        return view('login');
    }
    return redirect('/home');
});
Route::post('/login', 'AuthController@login');
Route::get('/login', function () {
    return redirect('/');
});
Route::post('/register', 'AuthController@register');
Route::get('/register', function () {
    return redirect('/');
});

//profile
Route::get('/profile', function () {
    if (!session()->has('data')) {
        return redirect('/');
    }
    return view('/profile');
});

Route::post('/updateProfile', 'AuthController@updateProfile');
Route::get('/updateProfile', function () {
    return redirect('/');
});

Route::post('/updatePassword', 'AuthController@updatePassword');
Route::get('/updatePassword', function () {
    return redirect('/');
});


Route::post('/getTasks', 'TaskController@all');
Route::get('/getTasks', function () {
    return redirect('/');
});

Route::post('/newTask', 'TaskController@create');
Route::get('/newTask', 'TaskController@view');

Route::post('/updateTask', 'TaskController@update');
Route::get('/updateTask', function () {
    return redirect('/');
});

//navigation menu
Route::get('/home', function () {
    if (!session()->has('data')) {
        return redirect('/');
    }
    return view('home');
});
