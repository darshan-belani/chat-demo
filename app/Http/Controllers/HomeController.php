<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Jobs\SendMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

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
        if (getAdminUser()->id != auth()->user()->id) {
            return view('user-chat');
        }
        $userData = User::where('id', '!=', auth()->user()->id)->get();
        return view('home', compact('userData'));
    }

    public function store(Request $request)
    {
        $sddMessage = new Chat();
        $sddMessage->sender_id = getAdminUser()->id;
        $sddMessage->receiver_id = $request->receiver_id;
        $sddMessage->message = $request->message;
        if ($sddMessage->save()) {
//                MessageSent::dispatch($userName, $roomId, $messageContent);
//                SendMessage::dispatch($sddUser);
            event(new MessageEvent($sddMessage));
            return response()->json([
                "status" => 200,
                "data" => $sddMessage,
                "message" => "data Save",
            ]);
        }
    }

    public function getMessage(Request $request) {
        $adminId = getAdminUser()->id;
        $userId = $request->userId;
        $message = Chat::where('receiver_id',$userId)->orWhere('sender_id',$userId)->paginate(10);
        /*$message = Chat::where('receiver_id',$userId)->orWhere('sender_id',$userId)map(function($da) {
        $orders = $da->orders->filter(function($order) {
            return $order->id == 67;
        })->get();*/
        $message->getCollection()->transform(function ($item) {
            $item->appendClass= 'incoming_msg';
            $item->appendMessageClass= 'received_msg';
            $item->appendStyleMessage = '';
            if ($item->receiver_id != 1 && $item->sender_id == 1) {
                $item->appendClass = 'outgoing_msg';
                $item->appendMessageClass = 'sent_msg';
                /*$item->appendStyle = '';
                $item->appendStyleMessage = '';*/
            }
            return $item;
        });
        return response()->json([
            "status"=>200,
            "data"=>$message,
        ]);
    }

    public function getUserMessage(Request $request) {
//        dd($request->all());
        $adminId = getAdminUser()->id;
        $sender_id = $request->sender_id;
        $message = Chat::where('receiver_id',$sender_id)
            ->orWhere('sender_id',$sender_id)
            ->paginate(20);
        /*$message = Chat::where('receiver_id',$userId)->orWhere('sender_id',$userId)map(function($da) {
        $orders = $da->orders->filter(function($order) {
            return $order->id == 67;
        })->get();*/
        $message->getCollection()->transform(function ($item) {
            $item->createdAt = date('Y-m-d', strtotime($item->created_at));
            $item->appendClass= 'incoming_msg';
            $item->appendMessageClass= 'received_msg';
            $item->appendStyleMessage = '';
            if ($item->receiver_id != getAdminUser()->id && $item->sender_id == auth()->user()->id) {
                $item->appendClass = 'outgoing_msg';
                $item->appendMessageClass = 'sent_msg';
                /*$item->appendStyle = '';
                $item->appendStyleMessage = '';*/
            } else {

            }
            return $item;
        });
        return response()->json([
            "status"=>200,
            "data"=>$message,
        ]);
    }

    public function messageStore(Request $request)
    {
        $addMessage = new Chat();
        $addMessage->sender_id = $request->sender_id;
        $addMessage->receiver_id = getAdminUser()->id;
        $addMessage->message = $request->message;
//        dd($sddMessage);
        if ($addMessage->save()) {
//                MessageSent::dispatch($userName, $roomId, $messageContent);
                SendMessage::dispatch($addMessage);
            event(new MessageEvent($addMessage));
            return response()->json([
                "status" => 200,
                "data" => $addMessage,
                "message" => "data Save",
            ]);
        }
    }
}
