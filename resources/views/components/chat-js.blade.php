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
                    'message_type': 'text'

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
        $.get("{{ url('message/recieve') }}", {
            "project_id": '{{ $project->id }}'
        }, function(result) {
            result = (result);
            // console.log('rec ', result.messagesCount)
            console.log(result);
            if (result.messagesCount > initCount) {
                // initCount ++;
                var d = new Date();
                initCount = result.messagesCount;

                if (result.messages.message_type == "text") {
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
                            .append('<div class="outgoing_msg"><div class="sent_msg"><p>' + result.messages
                                .message + '</p><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div></div>');
                    } else {
                        $("#msg_history")
                            .append('<div class="received_msg"><div class="received_withd_msg"><p>' + result
                                .messages.message + '</p><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div><a href="#">link to accept</a></div>');
                    }

                }

                if (result.messages.message_type == "file") {
                    var filePath = '{{ url("public/storage/") }}/'+result.messages.message ;
                    if (result.messages.sender == parseInt('{{ Auth::id() }}')) {

                        $("#msg_history")
                            .append(
                                '<div class="outgoing_msg"><div class="sent_msg"><a target="_blank" href="{{ url("public/storage/") }}/' +
                                result.messages.message + '"><i class="fa fa-file"></i>' + result.messages
                                .message + '</a><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div></div>');
                    } else {
                        $("#msg_history")
                            .append(
                                '<div class="received_msg"><div class="received_withd_msg"><a target="_blank" href="{{ url("public/storage/") }}/' +
                                result.messages.message + '"><i class="fa fa-file"></i>' + result
                                .messages.message + '</a><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span></div></div>');
                    }
                    $("#fileTable tbody").append(
                        '  <tr> <td><a target="_blank" class="text-primary" href="'+filePath+'">'+result.messages.message+'</a></td><td></td></tr>' )


                }


                if (result.messages.message_type == "file_submit") {
                    var filePath = '{{ url("public/storage/") }}/'+result.messages.message ;
                    if (result.messages.sender == parseInt('{{ Auth::id() }}')) {

                        $("#msg_history")
                            .append(
                                '<div class="outgoing_msg"><div class="sent_msg"><a target="_blank" href="{{ url("public/storage/") }}/' +
                                result.messages.message + '"><i class="fa fa-file"></i>' + result.messages
                                .message + '</a><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span><br><small>Project File delivered</small></div></div>');
                    } else {
                        $("#msg_history")
                            .append(
                                '<div class="received_msg"><div class="received_withd_msg"><a target="_blank" href="{{ url("public/storage/") }}/' +
                                result.messages.message + '"><i class="fa fa-file"></i>' + result
                                .messages.message + '</a><span>' + (d.getHours() + ":" + d.getMinutes()) +
                                '</span><br><small>Project File delivered</small></div></div>');
                    }
                    $("#fileTableSubmit tbody").append(
                        '  <tr> <td><a target="_blank" class="text-primary" href="'+filePath+'">'+result.messages.message+'</a></td><td></td></tr>' )


                }



                $("#last_msg_prev_{{$project->id}}").html(result.messages.message.substr(0,30));


                $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);


            }


        })
    }


    // const myTimeout = setTimeout( recieveMessage, 5);


    setInterval(() => {
        recieveMessage();
    }, 2000);

    // setTimeout(() => {
    //   recieveMessage();
    // }, 2000);


    $('#upload').on('click', function() {
        var file_data = $('#sortpicture').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        alert(form_data);
        $.ajax({
            url: 'upload.php', // <-- point to server-side PHP script 
            dataType: 'text', // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                alert(php_script_response); // <-- display response from the PHP script, if any
            }
        });
    });
</script>