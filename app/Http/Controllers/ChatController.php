<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index()
    {
        // count how many message are unread from the selected user
        // $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread
        // from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        // where users.id != " . Auth::id() . "
        // group by users.id, users.name, users.avatar, users.email");

        // $users = User::where('id','=',Auth::id());
        // $users = $users->with(['subusers'=>function($query){
        //     $query->withCount(['messages'=>function($query2){
        //         $query2->where('is_read',0);
        //         $query2->where('to',Auth::id());
        //     }]);
        // }]);
        // $users = $users->first();

        $users = User::where('id','=',Auth::id())->first();
        $users->setRelation('subusers',
            $users->subusers()->withCount(['messages'=>function($query2){
                $query2->where('is_read',0);
                $query2->where('to',Auth::id());
            }])->paginate(8)
        );
        if (request()->ajax()) {
            $view = view('chat.usersdiv', compact('users'))->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $users->subusers->nextPageUrl()]);
        }
        return view('chat.index2', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::with(['user'])->where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->paginate(8);
        $view  = view('chat.messages2', ['messages' => $messages])->render();
        return response()->json(['view'=>$view,'total_pages'=>$messages->lastPage()]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function chat()
    {
        return view('chat');
    }

}
