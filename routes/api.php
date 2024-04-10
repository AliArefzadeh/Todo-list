<?php
use App\Http\Controllers\Api\v1\AuthController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//public
Route::post('register',[AuthController::class,'register']);



//protected
Route::prefix('/v1')->group(function () {

    Route::get('auth/login', [AuthController::class, 'login'])->middleware('guest')->name('auth.login');
    Route::get('auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

});

