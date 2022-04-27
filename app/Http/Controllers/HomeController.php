<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Request as CustomerRequest;

use App\Models\Chat;
use App\Models\Messages;

use App\Models\BankDetail;
use App\Models\User;
use App\Mail\NewRequest;
use App\Mail\NewMessage;
use App\Mail\AcceptMail;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\PayUService\Exception;
use Stripe;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.adminPanel.index');
    }

    public function chat($id = null)
    {
        
        $user_id = auth()->user()->id;
        
        $chats = Chat::with(['user1', 'user2'])
            // ->where('user1_id', '<>', 1)
            // ->where('user2_id', '<>', 1)
            ->where(function($query) use($user_id) {
                $query->where('user1_id', $user_id)
                    ->orWhere('user2_id', $user_id);
            })
            ->get();
        
        Messages::where('receiver_id', $user_id)
            ->update(['read' => 1]);
        
        if ($id) {
            $chat_id = $id;
        } elseif ($chats->count()) {
            $chat_id = $chats->first()->id;
        } else {
            $chat_id = null;
        }
        
        $messages = $chat_id ? Messages::where('chat_id', $chat_id)->orderBy('created_at', 'desc')->get() : [];
        $chat_open = Chat::find($chat_id);
        //$role = auth()->user()->hasRole('Athlete') ? 'athlete' : 'customer';
        // dump($chat_open);
        // dump($chats);
      //   dd($messages[0]->request);
        return view('admin.adminPanel.support.chat', compact('chats', 'messages', 'chat_open'));
    }
    
    public function sendMsg(Request $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        $receiver_id = $chat->user1_id == auth()->user()->id ? $chat->user2_id : $chat->user1_id;
        
        Messages::create([
            'text' => $request->msg,
            'chat_id' => $chat->id,
            'sender_id' => auth()->user()->id,
            'receiver_id' => $receiver_id
        ]);
        
        $receiver = User::find($receiver_id);
        $sender = auth()->user();
        $details = [
            'id' => $chat->id,
            'receiver_name' => $receiver->first_name . ' ' . $receiver->last_name,
            'sender_name' => $sender->first_name . ' ' . $sender->last_name
        ];
        
        Mail::to($receiver->email)->send(new NewMessage($details));
    }

    public function refreshMsgs($chat_id)
    {
        $messages = Messages::where('chat_id', $chat_id)->orderBy('created_at', 'desc')->get();
        $response = view('messages', compact('messages'))->render();
        
        return $response;
    }
}
