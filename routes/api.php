<?php

use App\Http\Controllers\AdminController;use App\Http\Controllers\InfoController;use App\Http\Controllers\JingsaiController;use App\Http\Controllers\KeyanController;use App\Http\Controllers\ShuangchuangController;use App\Http\Controllers\XueXiController;use Illuminate\Http\Request;use Illuminate\Support\Facades\Route;
//use APP\Http\Controllers\DemoController;


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
//user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//Route::post('addss',[AdminController::class,'addss']);
//Route::post('addss',[AdminController::class,'addss']);
//
//
//Route::post('OssUpdate',[AdminController::class,'OssUpdate']); //oss


//Route::post('login',[DemoController::class,'login']);
Route::post('register',[\App\Http\Controllers\DemoController::class,'register']);
Route::post('/administrator/inquire', [\App\Http\Controllers\LywAdministratorController::class, 'inquire']);
Route::post('/administrator/increase', [\App\Http\Controllers\LywAdministratorController2::class, 'LywAdminInquire']);
Route::post('/administrator/delete', [\App\Http\Controllers\LywAdministratorController2::class, 'LywDelete']);
Route::post('/project/increase', [\App\Http\Controllers\LywAddProjectController::class, 'increase']);
