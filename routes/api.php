<?php

use App\Http\Controllers\ClientOfferController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("login",[UserController::class,'login']);
Route::post("logout",[UserController::class,'logout']);
Route::post("register",[UserController::class,'register']);


Route::prefix('message')->group(function(){
Route::post('send',[MessagesController::class, 'store']);
Route::get('recieve',[MessagesController::class, 'recieve']);
});

Route::get('projects',[ProjectController::class, 'get_all']);
Route::get('project/{user_id}',[ProjectController::class, 'get']);
Route::get('project/{user_id}/{project_id}',[ProjectController::class, 'get_with_id']);
Route::post('project/store',[ProjectController::class, 'store']);
Route::post('project/update/{id}',[ProjectController::class, 'update']);
Route::delete('project/delete/{id}',[ProjectController::class, 'destroy']);

Route::post('project/assignTeamLead/{id}',[ProjectController::class, 'assignTeamLead']);


Route::get('departments',[DepartmentsController::class, 'get']);
Route::post('department/store',[DepartmentsController::class, 'store']);
Route::post('department/{id}',[DepartmentsController::class, 'update']);
Route::delete('department/delete/{id}',[DepartmentsController::class, 'destroy']);

Route::post('clientOffer/store/{id}',[ClientOfferController::class, 'store']);

Route::get("clientOffer/getNotification/{id}", function($id){
    event(new \App\Events\OfferNotification('Someone'));
    return "Event has been sent!";
});