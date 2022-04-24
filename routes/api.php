<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthhController;
use App\Http\Controllers\Api\KeuanganController;
use App\Models\Keuangan;

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
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::post('/TambahKeuangan',[KeuanganController::class, 'create']);
Route::get('/Keuangan',[KeuanganController::class, 'index']);


Route::get('/getProfile',[AuthController::class, 'getProfile']);
Route::patch('updateProfile/{id}',[AuthhController::class, 'update']);

Route::patch('updateKeuangan/{id}',[KeuanganController::class, 'update']);
Route::resource('listKeuangan', KeuanganController::class);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'],function(){

});
