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
        $userData = User::where('id', '!=', auth()->user()->id)->get();
        return view('home', compact('userData'));
    }

    public function store(Request $request) {
            $sddUser = new Chat();
            $sddUser->sender_id = $request->sender_id;
            $sddUser->reciver_id = $request->reciver_id;
            $sddUser->message = $request->message;
            if ($sddUser->save()) {
//                MessageSent::dispatch($userName, $roomId, $messageContent);
//                SendMessage::dispatch($sddUser);
                                event( new MessageEvent($sddUser));
                return response()->json([
                    "status"=>200,
                    "data"=>$sddUser,
                    "message"=>"data Save",
                ]);
            }
    }
}
