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

Route::get('/', function () {
  return redirect()->route("backend.login");
});

Route::get('/login', function () {
  abort(404);
});

Route::get('/dashboard', function () {
  $hello = '';
  if(Auth::guard('admin')->check()){
    $hello = 'Hello admin';
  }else if(Auth::guard('web')->check()){
    $hello = 'Hello web';
  }
  return 'dashboard<br />' . $hello;
})->name('dashboard');