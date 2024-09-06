<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FlowController;
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

Route::get('/', [HomeController::class, "home"]);
Route::get('/auth', [HomeController::class, "login"]);
Route::get('/logout', [HomeController::class, "logout"]);
Route::get('/users', [UsersController::class, "home"]);
Route::get('/managment/apis', [APIController::class, "ApiManagment"]);
Route::get('/apis/{api:identifier}', [APIController::class, "apiCustom"]);
Route::get('/flows', [FlowController::class, "home"]);