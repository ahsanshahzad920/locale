<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Helpers\WebNotificationHelper;
use App\Models\ArchType;
use App\Models\Friend;
use App\Models\Message;
use App\Models\Position;
use App\Models\Stats;
use App\Notifications\DatabaseNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
//        WebNotificationHelper::addToLog('here');
        $athlete = User::select(
            'users.*',
            'roles.name as role',
            'user_details.position',
            'user_details.school',
            'user_details.coach',
            'user_details.player_efficiency',
            'user_details.field_goal',
            'user_details.date_of_birth',
            'user_details.player_style',
            'user_details.height',
            'user_details.weight')
            ->leftjoin('roles', 'roles.id', '=', 'users.type')
            ->leftjoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->first();
        $friend = Friend::where('user_id', $id)
            ->where('followed_by', Auth::id())->first();
        if ($friend) {
            $athlete->friend = true;
        } else {
            $athlete->friend = false;
        }
        $startDate = Carbon::parse($athlete->date_of_birth);
        $endDate = Carbon::parse(date('d-m-Y'));
        $diff = $startDate->diffInYears($endDate);
        $athlete->years = $diff;
        $position = Position::where('id', $athlete->position)->first();
        if (isset($position)) {
            $athlete->position = $position->name;
        }
        $style = ArchType::where('id', $athlete->player_style)->first();
        if (isset($style)) {
            $athlete->player_style = $style->name;
        }
        $stats = Stats::where('athlete_id', $id)->first();
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin')) {
            $users = User::select('users.first_name', 'users.last_name', 'users.id', 'users.picture')
                ->get();
        } else {
            $users = User::select('users.first_name', 'users.last_name', 'users.id', 'users.picture')
                ->leftjoin('roles', 'roles.id', '=', 'users.type')
                ->where('roles.name', 'Athlete')
                ->where('users.id','<>',Auth::id())
                ->get();
        }
        return view('admin.chats.index', compact('athlete', 'id', 'stats', 'users'));
    }


    public function show()
    {
        $athlete = User::select(
            'users.*',
            'roles.name as role',
            'user_details.position',
            'user_details.school',
            'user_details.coach',
            'user_details.player_efficiency',
            'user_details.field_goal',
            'user_details.date_of_birth',
            'user_details.player_style',
            'user_details.height',
            'user_details.weight')
            ->leftjoin('roles', 'roles.id', '=', 'users.type')
            ->leftjoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('users.id', Auth::id())
            ->first();
        $friend = Friend::where('user_id', Auth::id())
            ->where('followed_by', Auth::id())->first();
        if ($friend) {
            $athlete->friend = true;
        } else {
            $athlete->friend = false;
        }
        $position = Position::where('id', $athlete->position)->first();
        if (isset($position)) {
            $athlete->position = $position->name;
        }
        $style = ArchType::where('id', $athlete->player_style)->first();
        if (isset($style)) {
            $athlete->player_style = $style->name;
        }
        $startDate = Carbon::parse($athlete->date_of_birth);
        $endDate = Carbon::parse(date('d-m-Y'));
        $diff = $startDate->diffInYears($endDate);
        $athlete->years = $diff;
        $stats = Stats::where('athlete_id', Auth::id())->first();
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin')) {
            $users = User::select('users.first_name', 'users.last_name', 'users.id', 'users.picture')
                ->get();
        } else {
            $users = User::select('users.first_name', 'users.last_name', 'users.id', 'users.picture')
                ->leftjoin('roles', 'roles.id', '=', 'users.type')
                ->where('roles.name', 'Athlete')
                ->where('users.id','<>',Auth::id())
                ->get();
        }
        return view('admin.chats.show', compact('athlete', 'stats', 'users'));
    }

    public function fetchMessages($id)
    {
        return Message::with('user')
            ->where(function ($query) use ($id) {
                $query->where('send_by', '=', Auth::id())->where('send_to', '=', $id);
            })->orWhere(function ($query) use ($id) {
                $query->where('send_by', '=', $id)->where('send_to', '=', Auth::id());
            })->get();
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'message' => $request->message,
            'send_to' => $request->user_id,
            'send_by' => Auth::id(),
            'user_id' => Auth::id()
        ]);
        broadcast(new MessageSent($message->load('user')))->toOthers();
        $users = User::where('id', $request->user_id)->first();
        $url = route('chat.index', Auth::id());
        $data = collect([
            'title' => 'New Message form ' . Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'url' => $url,
            'picture' => Auth::user()->picture,
            'body' => $request->message
        ]);
        Notification::send($users, new DatabaseNotification($data));
        return ['status' => 'success', 'code' => 200];
    }

}
