@extends('layouts.app')

@section('content')
    <link href="{{ url('/') }}/assets/css/message.css" rel="stylesheet">


    <div class="row justify-content-center">
    <div class="col-6">
        <div class="messaging">
            <div class="inbox_msg">
              
                <div class="col-12">
                    <div class=" h4 alert text-dark shadow bg-white ">
                        {{ $project->title }} - Client Offer Conversation
                    </div>
                    <div class="msg_history" id="msg_history">




                        @foreach ($messages as $message)
                            @if ($message->message_type == 'offer_message')
                                @if (Auth::id() != $message->sender)
                                    <div class="incoming_msg">

                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p> <?=$message->message?></p>
                                                <span class="time_date">
                                                    {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p><?php echo ($message->message) ?></p>
                                            {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($message->message_type == 'offer')
                            @if (Auth::id() != $message->sender)
                                <div class="incoming_msg">

                                    <div class="received_msg">
                                         <?=$message->message?>

                                         <div class="d-flex">
                                             @if(\App\Models\ClientOffer::where("project_id", $project->id)->value("response") == 0)
                                         <form action="{{url('client-offer/'.$project->id.'/1')}}" method="post"
                                            id="accept_form_{{$message->id}}">
                                            <button class="btn btn-sm btn-success"  >
                                                Accept
                                            </button>
                                        </form>

                                        <form action="{{url('client-offer/'.$project->id.'/-1')}}" method="post"
                                            id="accept_form_{{$message->id}}">
                                            <button class="btn btn-sm btn-danger ml-4"  >
                                                Reject
                                            </button>
                                        </form>
                                        @endif
                                    </div>

                                            <span class="time_date">
                                                {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                             
                                    </div>
                                    
                                </div>
                            @else
                                <div class="outgoing_msg">
                                 <?php echo ($message->message) ?>
                                        {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                </div>
                            @endif
                        @endif

                        @endforeach

                    </div>
                
                    <div class="input-group mb-3">
                        @if(\App\Models\ClientOffer::where("project_id", $project->id)->value("response") == 1)
                        <p class="text-success font-weight-bold">Price and time offered by Acelocale is accepted.</p>
                        @endif
    
                        @if(\App\Models\ClientOffer::where("project_id", $project->id)->value("response") == -1)
                        <p class="text-danger font-weight-bold">Price and time offered by Acelocale was refused.</p>
                        @endif
                        <input type="text" class="write_msg form-control " style="width: 70%" id="msg_text"
                            placeholder="Type a message" />

                        <div class="input-group-append">
                            <button class="btn btn-primary" onclick="sendMessage(document.getElementById('msg_text').value)" id="msg_send_btn" type="button"><i
                                    class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                 
            </div>

        </div>
    </div>
        @include('components.offer-chat-js')
    @endsection

