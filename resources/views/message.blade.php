
    <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">{{$message->sender->name}}</span>
                      <span class="direct-chat-timestamp float-right">{{ $message->created_at }}</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    @if(Auth::user()->role_id=='1')
                    <img class="direct-chat-img" src="{{ $message->sender->picture ?? '/vendor/dist/img/user2-160x160.jpg' }}" alt="message user image">
                    @else
                    <img class="direct-chat-img" src="{{ $message->sender->picture ?? '/vendor/dist/img/user8-128x128.jpg' }}" alt="message user image">
                    @endif
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                    {!! $message->text !!}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>