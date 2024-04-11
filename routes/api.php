<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TodoController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//public
Route::post('register',[AuthController::class,'register']);
/*Route::get('/mail/{user}', [MailController::class, 'sendVerificationEmail'])->name('send.email');
Route::get('/verify/{user}', [MailController::class, 'verifyEmail'])->name('verify.email');*/

//global protected
Route::prefix('/v1')->group(function () {

    Route::get('auth/login', [AuthController::class, 'login'])->middleware('guest')->name('auth.login');
    Route::get('auth/me', [AuthController::class, 'me'])->middleware(['auth:sanctum','json']);
    Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

});

//active protected

Route::group(['prefix' => 'active','middleware' => ['json','auth:sanctum', 'abilities:todo:crud']],function () {

    Route::get('/todo/{todo}',[TodoController::class,'index'])->name('todo.index');
    Route::post('/todo',[TodoController::class,'store'])->name('todo.store');
    Route::put('todo/{todo}',[TodoController::class,'update'])->name('todo.update');
    Route::delete('todo/{todo}',[TodoController::class,'destroy'])->name('todo.destroy');

});
