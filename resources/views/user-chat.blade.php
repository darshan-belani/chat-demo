@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                {{--message box--}}
                <input type="hidden" name="_token" id="token" class="token"
                       value="{{ csrf_token() }}">
                <input type="hidden" name="sender_id" id="sender_id" class="sender_id"
                       value="{{ auth()->user()->id }}">
                <div class="user-mesgs" style="{{ auth()->user()->role == "1" ? 'display: none' : 'display: block'  }}">
                   {{-- <div class="user_msg_history">

                    </div>--}}
                    <div class="chat-message-list" id="chat-message-list">
                        <div class="user_msg_history">

                        </div>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="write_msg" placeholder="Type a message"/>
                            <button class="msg_send_btn user_send_message" type="button"><i class="fa fa-paper-plane-o"
                                                                          aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>


            <p class="text-center top_spac"> Design by
                <a target="_blank" href="#">
                    Darshan Belani
                </a>
            </p>
        </div>
    </div>
    <script src="{{asset('js/user-chat.js')}}"></script>
@endsection



