<?php

use Illuminate\Support\Facades\Route;
use Laudis\Neo4j\Contracts\ClientInterface;

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

Route::get('/', function (ClientInterface $client) {
    return view('welcome', ['client' => $client]);
});

Route::get('/login', function (ClientInterface $client) {
    return view('login', ['client' => $client]);
});

Route::get('/login/doit', "App\\Http\\Controllers\\LoginController@login");

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
