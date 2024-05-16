@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                @if(auth()->user()->role == "1")
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                            <div class="srch_bar">
                                <div class="stylish-input-group">
                                    <input type="text" class="search-bar" placeholder="Search">
                                    <span class="input-group-addon">
                                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="inbox_chat">
                            @foreach($userData as $key => $value)
                                <div class="chat_list" data-id="{{ $value->id }}">
                                    <div class="chat_people">
                                        <div class="chat_img">
                                            <img src="{{ asset('images/user-profile.png') }}" alt="sunil">
                                        </div>
                                        <input type="hidden" value="{{ $value->id }}" class="user_id">
                                        <input type="hidden" name="_token" id="token" class="token"
                                               value="{{ csrf_token() }}">
                                        <div class="chat_ib">
                                            <h5 class="username">{{ ucwords($value->name) }} <span
                                                        class="chat_date">Dec 25</span></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{--message box--}}
                <div class="mesgs" style="{{ auth()->user()->role == "1" ? 'display: none' : 'display: block'  }}">
                    {{--<div class="mesgs">--}}
                    <div class="msg_history">

                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="write_msg" placeholder="Type a message"/>
                            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o"
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
    <script src="{{asset('js/custom.js')}}"></script>
@endsection



