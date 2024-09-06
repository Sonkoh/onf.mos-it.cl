<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
function formatToTime($time)
{
    $seconds = intval($time);
    $milliseconds = substr(str_replace('.', '', $time - $seconds), 0, 3);
    return date('s', $seconds) . '.' . str_pad($milliseconds, 3, '0', STR_PAD_RIGHT);
}

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/user/create', [UsersController::class, 'create']);
Route::post('/user/edit', [UsersController::class, 'edit']);
Route::post('/user/delete', [UsersController::class, 'delete']);
Route::post('/execute/{api}/{vno}/{envrioment}', [APIController::class, 'executeAPI']);
Route::post('/clone/{report}', [APIController::class, 'cloneRequest']);
Route::post('/account/update_password', [AuthController::class, 'update_password']);

Route::get('/v2/flow/request/{flow}/{vno}', [FlowController::class, 'request_flow']);