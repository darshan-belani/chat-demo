@extends('layouts.app')

@section('content')
    <style>
        .left-section {
            background-color: #2d3748;
            height: 500px;
            color: white
        }

        .userlist {
            background-color: blue;
            height: 59px;
            margin-top: 26px;
            text-align: center;
            border-radius: 8px;
        }

        .userlist span {
            top: 18px;
            font-weight: bold;
            position: relative;
        }

        .right-section {
            background-color: #718096;
            height: 500px;
            color: white
        }

        .message-list {
            margin-top: 50px;
        }

        .message-box {
            width: 78%
        }

        .send-button {
            width: 100px;
            margin-left: 12px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="container">
                        <div class="row">

                            <div class="col-xs-12 col-md-4 left-section">
                                @foreach($userData as $key => $value )
                                    <div class="userlist">
                                        <button class="user_id" value="{{$value->id}}">{{ ucwords($value->name )}}</button>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" value="{{ auth()->user()->id  }}" class="sender_id">
                            <div class="col-xs-6 col-md-8 right-section">
                                <div class="sendMessage">
                                    <div class="row message-list">
                                        <div class="message">
                                            <div class="current-user-chat">
                                                <h5>hi</h5>
                                            </div>
                                        </div>
                                        <input class="form-control message-box" type="text" name="message">
                                        <button class="btn btn-primary send-button">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        let reciver_id = "";
        let sender_id = $(".sender_id").val();
        $(document).on('click', '.user_id', function(e) {
            reciver_id = $(".user_id").val()
            console.log("reciver_id",reciver_id)
        })
        $(document).on('click', '.send-button', function(e) {
            const message = {
                "_token": "{{ csrf_token() }}",
                sender_id: $(".sender_id").val(),
                reciver_id: reciver_id,
                message: $(".message-box").val(),
            };
            $.ajax({
                url: '{{ route('chat.send') }}',
                type: 'post',
                data: message,
                success: function(response){
                    if(response.status == 200)
                        var messageData = '<div class="current-user-chat">\n' +
                            '              <h5>'+ message.message+'</h5>\n' +
                            '          </div>';
                    console.log("message", messageData)
                    $('.message').append(messageData)
                        // alert('Save successfully.');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            Echo.private('brodcast-message')
                .listen('.getChatMessage', (data) => {
                    console.log('data', data)
                    console.log("sender_id", sender_id)
                    if (sender_id == data.chat.reciver_id && reciver_id == data.chat.sender_id)  {
                        var messageData = '<div class="current-user-chat">\n' +
                            '              <h5>'+ data.chat.message+'</h5>\n' +
                            '          </div>';
                        $('.message').append(messageData)
                }

                })
        })
        // window.Echo.private('brodcast-message')
        //     .listen('.getChatMessage', (data) => {
        //         console.log('data', data)
        //     })
    </script>
@endsection
