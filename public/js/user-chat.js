$(document).ready(function () {

    $(".messages").animate({scrollTop: $(document).height()}, "fast");

    var sender_id = $('.sender_id').val();
    let page = 1; // Initial page number
    let totalPage = ''
    /*$('.msg_history').scroll(function() {
        if($('.msg_history').scrollTop() + $('.msg_history').height() == $(document).height()) {
            console.log("in")
            if (!isLoading) {
                isLoading = true;
                getMessage(userId);
            }
        }
    });*/

   /* $('.user_msg_history').scroll(function() {
        console.log('scrollTop:', $('.user_msg_history').scrollTop());
        console.log('height:', $('.user_msg_history').height());
        console.log('document height:', $(document).height());

        if($('.user_msg_history').scrollTop() + $('.user_msg_history').height() >= $('.user_msg_history').height() && page != 6 ) {
            console.log("Reached the bottom");
            // Your code here
            // if (!isLoading) {
                isLoading = true;
                page++;
                getMessage(sender_id);
            // }
        }
    });*/
    var isLoading = false;
    $('.chat-message-list').scroll(function() {
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(this)[0].scrollHeight;
        var windowHeight = $(this).innerHeight();

        // Check if scrolled to the bottom and not loading already
        if (scrollTop == 0 &&  page != 5 ) {
            isLoading = true;
            page++; // Increment page number
            getMessage(sender_id, page);
        }
    });


    getMessage(sender_id);
    $(".user_send_message").click(function () {
        const message = {
            "_token": $('.token').val(),
            sender_id: sender_id,
            message: $('.write_msg').val(),
        };
        $.ajax({
            url: '/user/chat/send-message',
            type: 'post',
            data: message,
            success: function (response) {
                if (response.status == 200)
                    var messageData = '<div class="outgoing_msg">\n' +
                            '<div class="sent_msg">\n' +
                                '<div class="received_withd_msg">\n' +
                                    '<p>' + message.message + '</p>\n' +
                                    '<span class="time_date">' + message.createdAt + '</span>' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                $('.user_msg_history ').append(messageData)
                // alert('Save successfully.');
            }
        });
    });
    console.log("getMessage")

    function getMessage(sender_id, page) {
        $.ajax({
            // headers: {
            //     '_token': "{{ csrf_token() }}"
            // },
            url: '/user/chat/get-message?page=' + (page),
            type: 'post',
            data: {"sender_id": sender_id, "_token": $('.token').val()},
            success: function (response) {
                // console.log("ddd",response.data)
                if (response.status == 200)
                    $('.user_msg_history ').html('');
                $('.write_msg').text('')
                data = response.data.data;
                totalPage = data.last_page
                // console.log("data",data);
                let oldDate = null;
                var $chatContainer = $('.user_msg_history');
                var dateGroups = {};

                data.forEach(function(message) {
                    var date = new Date(message.createdAt).toDateString();
                    if (!dateGroups[date]) {
                        dateGroups[date] = [];
                    }
                    dateGroups[date].push(message);
                });

                for (var date in dateGroups) {
                    $chatContainer.append('<div class="show_date">' + date + '</div>');
                    dateGroups[date].forEach(function(message) {
                        var getMessage =
                            '<div class="'+ message.appendClass +'">\n' +
                            '       <div class="'+ message.appendMessageClass +'">\n' +
                            '           <div class="received_withd_msg">\n' +
                            '               <p>'+ message.message +'</p>\n' +
                            '               <span class="time_date">' + message.createdAt + '</span></div>\n' +
                            '       </div>\n' +
                            '   </div>';
                        $chatContainer.append(getMessage);
                    });
                }
                /*var groupedMessages = {};
                data.forEach(function(message) {
                    var date = new Date(message.createdAt);
                    var day = date.toDateString();
                    console.log(day)
                    if (!groupedMessages[day]) {
                        groupedMessages[day] = [];
                    }
                    groupedMessages[day].push(message);
                });

                // Append messages to chat container with day headings
                var chatContainer = $('.user_msg_history');
                for (var day in groupedMessages) {
                    chatContainer.append('<span class="show_date">' + day + '</span>');
                    var messages = groupedMessages[day];
                    messages.forEach(function(message) {
                        var getMessage =
                            '<div class="'+ message.appendClass +'">\n' +
                            '       <div class="'+ message.appendMessageClass +'">\n' +
                            '           <div class="received_withd_msg">\n' +
                            '               <p>'+ message.message +'</p>\n' +
                            '               <span class="time_date">' + message.createdAt + '</span></div>\n' +
                            '       </div>\n' +
                            '   </div>';
                        chatContainer.append(getMessage);
                    });
                    isLoading = false;
                }*/
                /* data.forEach(function(message){
                    console.log("index",message.createdAt);
                    // oldDate = message.createdAt;
                    let showMessage = '';
                    console.log("oldDate",oldDate)
                    if (oldDate != message.createdAt) {
                        console.log("in");
                        showMessage = '<span class="show_date">'+ oldDate +'</span>\n';
                        oldDate = message.createdAt;
                        $('.user_msg_history ').prepend('<span class="show_date">'+ oldDate +'</span>\n')

                    }
                    var getMessage =
                        '<span class="show_date">'+ oldDate +'</span>\n'+
                        '<div class="'+ message.appendClass +'">\n' +
                        '       <div class="'+ message.appendMessageClass +'">\n' +
                        '           <div class="received_withd_msg">\n' +
                        '               <p>'+ message.message +'</p>\n' +
                        '               <span class="time_date"> 11:01 AM    |    June 9</span></div>\n' +
                        '       </div>\n' +
                        '   </div>';
                    // console.log("message", getMessage)

                    $('.user_msg_history ').prepend(getMessage)

                    // page++; // Increment page number
                    isLoading = false;
                    // alert('Save successfully.');
                });*/

            }
        });
    }
});
//# sourceURL=pen.js