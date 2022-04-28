<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ClientOfferController;
// use App\Http\Controllers\SubAdminController;


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
    return view('welcome');
});
Auth::routes(['verify' => true]);

Route::middleware(["auth","verified"])->group(function(){
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix("admin")->middleware(["auth"])->group(function(){
Route::get("home", [\App\Http\Controllers\HomeController::class,'admin']);

//SubAdmin Controller
Route::prefix("subAdmin")->group(function(){
Route::get("index",[\App\Http\Controllers\SubAdminController::class,'index']);
Route::get("create",[\App\Http\Controllers\SubAdminController::class,'create']);
Route::post("store",[\App\Http\Controllers\SubAdminController::class,'store']);
Route::get("show/{id}",[\App\Http\Controllers\SubAdminController::class,'show'])->name('admin.subAdmin.show');
Route::get("edit/{id}",[\App\Http\Controllers\SubAdminController::class,'edit'])->name('admin.subAdmin.edit');
Route::post("update/{id}",[\App\Http\Controllers\SubAdminController::class,'update']);
Route::post("delete",[\App\Http\Controllers\SubAdminController::class,'delete'])->name('admin.subAdmin.delete');
});


//Clients Controller
Route::prefix("clients")->group(function(){
Route::get("index",[\App\Http\Controllers\ClientController::class,'index']);
Route::get("create",[\App\Http\Controllers\ClientController::class,'create']);
Route::post("store",[\App\Http\Controllers\ClientController::class,'store']);
Route::get("edit/{id}",[\App\Http\Controllers\ClientController::class,'edit']);
Route::post("update/{id}",[\App\Http\Controllers\ClientController::class,'update']);
Route::post("delete/{id}",[\App\Http\Controllers\ClientController::class,'delete']);
});


//Admin TeamLeads Controller
Route::prefix("teamlead")->group(function(){
Route::get("index",[\App\Http\Controllers\TeamLeadController::class,'index']);
Route::get("create",[\App\Http\Controllers\TeamLeadController::class,'create']);
Route::post("store",[\App\Http\Controllers\TeamLeadController::class,'store']);
Route::get("edit/{id}",[\App\Http\Controllers\TeamLeadController::class,'edit'])->name('admin.teamlead.edit');
Route::post("update/{id}",[\App\Http\Controllers\TeamLeadController::class,'update']);
Route::post("delete",[\App\Http\Controllers\TeamLeadController::class,'delete'])->name('admin.teamlead.delete');;
});

//Admin TeamLeads Controller
Route::prefix("support")->group(function(){
Route::get("index",[\App\Http\Controllers\SupportController::class,'index']);
Route::get("create",[\App\Http\Controllers\SupportController::class,'create']);
Route::post("store",[\App\Http\Controllers\SupportController::class,'store']);
Route::get("edit/{id}",[\App\Http\Controllers\SupportController::class,'edit']);
Route::post("update/{id}",[\App\Http\Controllers\SupportController::class,'update']);
Route::post("delete/{id}",[\App\Http\Controllers\SupportController::class,'delete']);
});
// chat
Route::get('chat/{id?}',[\App\Http\Controllers\HomeController::class,'chat'])->name('chat');
Route::get('send-msg', [\App\Http\Controllers\HomeController::class,'sendMsg']);
Route::get('refresh-msgs/{id}', [\App\Http\Controllers\HomeController::class,'refreshMsgs']);
//Admin Invoices Controller
Route::prefix("invoices")->group(function(){
Route::get("index",[\App\Http\Controllers\InvoicesController::class,'index']);
Route::get("show/{id}",[\App\Http\Controllers\InvoicesController::class,'show']);

});

//Clients TeamLeads
Route::prefix("teamleads")->group(function(){
Route::get("index",[\App\Http\Controllers\TeamLeadsController::class,'index']);
Route::get("create",[\App\Http\Controllers\TeamLeadsController::class,'create']);
Route::post("store",[\App\Http\Controllers\TeamLeadsController::class,'store']);
Route::get("edit/{id}",[\App\Http\Controllers\TeamLeadsController::class,'edit']);
Route::post("update/{id}",[\App\Http\Controllers\TeamLeadsController::class,'update']);
Route::post("delete/{id}",[\App\Http\Controllers\TeamLeadsController::class,'delete']);
});

// Feedsback
Route::prefix("feedback")->group(function(){
    Route::get("index",[\App\Http\Controllers\FeedbackController::class,'index']);
    Route::get("create",[\App\Http\Controllers\FeedbackController::class,'create']);
    Route::post("store",[\App\Http\Controllers\FeedbackController::class,'store']);
    Route::get("edit/{id}",[\App\Http\Controllers\FeedbackController::class,'edit']);
    Route::post("update/{id}",[\App\Http\Controllers\FeedbackController::class,'update']);
    Route::post("delete/{id}",[\App\Http\Controllers\FeedbackController::class,'delete']);
    });
Route::post('client_feedback',[\App\Http\Controllers\FeedbackController::class,'client_feedback']);

Route::get('project/offer-chat/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'messages_offer_chat_admin']);

Route::get("inbox", [\App\Http\Controllers\AdminController::class,'inbox']);

Route::get("projects", function(){

});

Route::get('project/messages/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'messages_admin']);

});

Route::prefix("teamlead")->group(function(){
    Route::get("home", function(){
    
    });
    
    Route::get("messages", function(){  
    }); 
    Route::get("projects", [\App\Http\Controllers\ProjectController::class , 'index_teamlead']); 
    Route::get('project/messages/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'messages_teamlead']);
    });

Route::prefix('user')->middleware('auth')->group(function(){

Route::get('projects',[\App\Http\Controllers\ProjectController::class, 'index']);
Route::get('project',[\App\Http\Controllers\ProjectController::class, 'create']);
Route::get('project/{id}',[\App\Http\Controllers\ProjectController::class, 'edit']);
Route::get('project/view/{id}',[\App\Http\Controllers\ProjectController::class, 'view']);
Route::get('project/messages/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'messages']);
Route::get('project/initiate-offer-chat/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'initiateOffer']);
Route::get('project/offer-chat/{id}/{invoice}',[\App\Http\Controllers\ProjectController::class, 'messages_offer_chat']);


Route::post('project',[\App\Http\Controllers\ProjectController::class, 'store']);
Route::put('project/{id}',[\App\Http\Controllers\ProjectController::class, 'update']);
Route::delete('project/{id}',[\App\Http\Controllers\ProjectController::class, 'delete']);
});
Route::get('message/recieve',[MessagesController::class, 'recieve']);
Route::get('message/recieve/offer_chat',[MessagesController::class, 'recieve_offer_chat']);

Route::post('client-offer/{id}/{response}',[ClientOfferController::class, 'response_to_offer']);
});

Route::post('message/uploadFiles/{chat_id}/{user_id}',[MessagesController::class, 'uploadFiles']);

Route::post('message/uploadFilesForSubmit/{chat_id}/{user_id}',[MessagesController::class, 'uploadFiles']);


Route::get('notifications', function(){
    return view('notifications');
});
Route::get('test-notification/{data}', function ($data) {
    // event(new App\Events\StatusLiked('Someone'));
    event(new App\Events\OfferNotification(' OFFER NOTIFICATION '.$data));

    return "OFFER has been sent!";
});