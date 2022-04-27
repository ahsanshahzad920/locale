@extends('layouts.apps')

@section('content')


<div class="content-wrapper">
 <!-- DIRECT CHAT -->
 <div class="card direct-chat direct-chat-primary">
 <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                  <span title="3 New Messages" class="badge badge-primary">3</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                                @include('messages', ['messages' => $messages])
                </div>
                <!--/.direct-chat-messages-->

                <!-- Contacts are loaded here -->
                
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input type="text" name="message" data-chat_id="{{ $chat_open->id }}" placeholder="Type Message ..." class="form-control msg">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary send-msg">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
  </div>
</div>  
            <!--/.direct-chat -->
    @endsection        
    @section('scripts')



<script>
    $(document).ready(function () {
        
        $('.send-msg').on('click', function (e) {
            e.preventDefault();
            
            let msg = $('.sent-msg');
            let text = $('.msg').val();
            let chat_id = $('.msg').data('chat_id');

            msg.find('.content').text(text);
            msg.removeClass('d-none');
            msg.addClass('d-flex');

            $('.messages').append(msg);
            $('.msg').val('');
            $('.no-msgs').hide();

            $.ajax({
                url: '/admin/send-msg',
                data: {
                    msg: text,
                    chat_id: chat_id
                },
                success: function (res) {

                }
            });
        });
        
        let myVar = setInterval(refreshMsgs, 5000);

        function refreshMsgs() {
            $.ajax({
                url: '/admin/refresh-msgs/' + $('.msg').data('chat_id'),
                success: function (res) {
                    $('.direct-chat-messages').html(res);
                }
            });
        }
    });
</script>

@endsection