$(document).ready(function () {

    $(".messages").animate({scrollTop: $(document).height()}, "fast");

    var userId = "";
    $(".chat_list").click(function () {
        $('.chat_list').removeClass("active_chat");

        $(this).addClass("active_chat");
        userId = $(this).data('id');
        $('.mesgs').show();
        getMessage(userId);
        console.log("userId ", userId)
    });
    let adminId =
    $(".msg_send_btn").click(function () {
        const message = {
            "_token": $('.token').val(),
            userId: userId,
            message: $('.write_msg').val(),
        };
        $.ajax({
            url: '/chat/send-message',
            type: 'post',
            data: message,
            success: function (response) {
                if (response.status == 200)

                    var messageData = '<div class="outgoing_msg">\n' +
                        '<div class="sent_msg">\n' +
                            '<div class="received_withd_msg">\n' +
                                '<p>' + message.message + '</p>\n' +
                                '<span class="time_date"> 11:01 AM    |    June 9</span>' +
                            '</div>\n' +
                        '</div>\n' +
                    '</div>\n' +
                console.log("message", messageData)
                $('.message').append(messageData)
                // alert('Save successfully.');
            }
        });
        // console.log("message", message, "userId--- ", userId)
    });
    console.log("getMessage")
    function getMessage(userId) {
        $.ajax({
            url: '/chat/get-message',
            type: 'post',
            data: {"userId": userId, "_token": $('.token').val()},
            success: function (response) {
                // console.log("ddd",response.data)
                if (response.status == 200)
                    $('.msg_history').html('');
                data = response.data.data;
                console.log("data",data);
                data.forEach(function(message){
                    console.log("index",message.message);
                    var getMessage =
                        '<div class="'+ message.appendClass +'">\n' +
                        '       <div class="'+ message.appendMessageClass +'">\n' +
                        '           <div class="received_withd_msg">\n' +
                        '               <p>'+ message.message +'</p>\n' +
                        '               <span class="time_date"> 11:01 AM    |    June 9</span></div>\n' +
                        '       </div>\n' +
                        '   </div>';
                    // console.log("message", getMessage)
                    $('.msg_history').append(getMessage)
                    // alert('Save successfully.');
                });

            }
        });
    }
});
//# sourceURL=pen.js