<script>
    window.onload = function() {
        $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);

    }
    var initCount = parseInt('{{ sizeof($messages) }}');

    document.getElementById('msg_text').addEventListener('keypress', function(e) {
        if (event.which === 13) {
            sendMessage(document.getElementById('msg_text').value);
        }
    })

    function sendMessage(message) {
        if (message != '') {
            $.post("{{ url('api/message/send') }}", {
                    'project_id': '{{ $project->id }}',
                    'message': message,
                    'sender': '{{ Auth::id() }}',
                    'message_type': 'offer_message'

                },
                function(result) {
                    console.log(result);
                    recieveMessage()
                    document.getElementById('msg_text').value = '';


                })
        }
    }

    // function sendMessage() {
    //     if (document.getElementById('msg_text').value != '') {
    //         $.post("{{ url('api/message/send') }}", {
    //                 'project_id': '{{ $project->id }}',
    //                 'message': document.getElementById('msg_text').value,
    //                 'sender': '{{ Auth::id() }}'
    //             },
    //             function(result) {
    //                 console.log(result);
    //                 recieveMessage()
    //                 document.getElementById('msg_text').value = '';


    //             })
    //     }
    // }


    function recieveMessage() {

        // console.log('init count', initCount)
        $.get("{{ url('message/recieve/offer_chat') }}", {
            "project_id": '{{ $project->id }}'
        }, function(result) {
            result = (result);
            // console.log('rec ', result.messagesCount)
            console.log(result);
            console.log("message count ", result.messagesCount)
            console.log("init count ", initCount)

            if (result.messagesCount > initCount) {
                // initCount ++;
                var d = new Date();
                initCount = result.messagesCount;

                if (result.messages.message_type == "offer_message") {
                    if (result.messages.sender == parseInt('{{ Auth::id() }}')) {

                        $("#msg_history")
                            .append('<div class="outgoing_msg"><div class="sent_msg"><p>' + result.messages
                                .message + '</p><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div></div>');
                    } else {
                        $("#msg_history")
                            .append('<div class="received_msg"><div class="received_withd_msg"><p>' + result
                                .messages.message + '</p><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div></div>');
                    }

                }

                
                if (result.messages.message_type == "offer") {
                    if (result.messages.sender == parseInt('{{ Auth::id() }}')) {

                        $("#msg_history")
                            .append('<div class="outgoing_msg">' + result.messages
                                .message + '<span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div>');
                    } else {
                        $("#msg_history")
                            .append('<div class="received_msg">' + result
                                .messages.message + '<span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span>'+
                                '<div class="d-flex">'+
                                            
                                         '<form action="{{url('client-offer/'.$project->id.'/1')}}" method="post" id="accept_form_{{$project->id}}">'+
                                            '<button class="btn btn-sm btn-success" >Accept  </button>  </form>'+

                                        '<form action="{{url('client-offer/'.$project->id.'/-1')}}" method="post" id="accept_form_{{$project->id}}">  <button class="btn btn-sm btn-danger ml-4" > Reject </button>  </form>'+
                                    '</div>'

                                +'</div>');
                    }

                }


                $("#last_msg_prev_{{$project->id}}").html(result.messages.message.substr(0,30));


                $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);


            }


        })
    }


    // const myTimeout = setTimeout( recieveMessage, 5);


    setInterval(() => {
        recieveMessage();
    }, 1000);


</script>