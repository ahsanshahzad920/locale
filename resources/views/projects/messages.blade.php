@extends('layouts.app')

@section('content')
    <link href="{{ url('/') }}/assets/css/message.css" rel="stylesheet">


    <div class="w-100">
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">

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
                        @foreach ($projects as $item)
                            <a href="{{ url('user/project/messages/' . $item->id . '/' . $item->invoice_number) }}">
                                <div class="chat_list @if ($item->id == $project->id) active_chat @endif">
                                    <div class="chat_people">
                                        <div class="chat_img"> <img
                                                src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                        <div class="chat_ib">
                                            <h5>{{ $item->title }} <span
                                                    class="chat_date">{{ date('d M', strtotime($item->created_at)) }}</span>
                                            </h5>
                                            <small id="last_msg_prev_{{$item->id}}">
                                                @if(strlen(\App\Models\Messages::getLastMessage($item->id) ) <30)
                                                {{\App\Models\Messages::getLastMessage($item->id)}}
                                                @else
                                                {{ substr(\App\Models\Messages::getLastMessage($item->id), 0, 30) }}...
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
                <div class="mesgs">
                    <div class=" h4 alert text-dark shadow bg-white ">
                        {{ $project->title }}
                    </div>
                    <div class="msg_history" id="msg_history">
                        @if(Auth::user()->role == "client")
                        <div class="incoming_msg" id="incoming_msg">
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p>{{ $project->description }}
                                        <br>

                                        <br>
                                        <a target="_blank" class="btn btn-light text-wrap text-sm btn-sm"
                                            href="{{ url('public/storage/' . $project->document) }}">
                                            <?php echo \App\Helpers\AppHelpers::getFileIcon($project->document); ?>
                                            <span class="ml-1 font-weight-bold">
                                                {{ substr(str_replace('documents/', '', $project->document), 0, 10) }}
                                                ..</span>
                                        </a>
                                    </p>

                                    <span class="time_date">
                                        {{ date('H:i | d M', strtotime($project->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>{{ $project->description }}
                                    <br>
                                    <small>Attached Docuemnts</small>
                                    <br>
                                    <a target="_blank" class="btn btn-light text-wrap text-sm btn-sm"
                                    href="{{ url('public/storage/' . $project->document) }}">
                            <?php echo \App\Helpers\AppHelpers::getFileIcon($project->document) ?> 
                                   <span class="ml-1 font-weight-bold"> {{ substr(str_replace('documents/', '', $project->document), 0 , 10) }} ..</span>
                                </a>
                                </p>

                                <span class="time_date">
                                    {{ date('H:i | d M', strtotime($project->created_at)) }}</span>
                            </div>
                        </div>

                        @endif



                        @foreach ($messages as $message)
                            @if ($message->message_type == 'text')
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
                                        <div class="received_withd_msg">
                                            <p> <?=$message->message?></p>
                                            <a href="#">link to accept</a>

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

                            @if ($message->message_type == 'file')
                                @if (Auth::id() != $message->sender)
                                    <div class="incoming_msg">

                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <a target="_blank"
                                                    href="{{ url('public/storage/' . $message->message) }}">
                                                    <i class="fa fa-file"></i>
                                                    {{ $message->message }}</a>
                                                <span class="time_date">
                                                    {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <a target="_blank" href="{{ url('public/storage/' . $message->message) }}">
                                                <i class="fa fa-file"></i>
                                                {{ $message->message }}</a>
                                            <span>{{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif


                            @if ($message->message_type == 'file_submit')
                            @if (Auth::id() != $message->sender)
                                <div class="incoming_msg">

                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <a target="_blank"
                                                href="{{ url('public/storage/' . $message->message) }}">
                                                <i class="fa fa-file"></i>
                                                {{ $message->message }}</a>
                                            <span class="time_date">
                                                {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                                <br><small>Project File delivered</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                                        <a target="_blank" href="{{ url('public/storage/' . $message->message) }}">
                                            <i class="fa fa-file"></i>
                                            {{ $message->message }}</a>
                                       <span> {{ date('H:i | d M', strtotime($message->created_at)) }}</span>
                                        <br><small>Project File delivered</small>

                                    </div>
                                </div>
                            @endif
                        @endif

                        @endforeach

                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="write_msg form-control " style="width: 70%" id="msg_text"
                            placeholder="Type a message" />

                        <div class="input-group-append">
                            <button class="btn btn-primary" onclick="sendMessage(document.getElementById('msg_text').value)" id="msg_send_btn" type="button"><i
                                    class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="w-100 container d-inline">
                        <label id="sendFileBtn" class="flex mr-2 btn btn-outline-primary my-0 ">
                            <i class="fa fa-file"></i>
                            Send File
                            <input type="file" name="files[]" multiple class="d-none" id="selectedFiles"
                                onchange="chooseAndAppendFile(this)">
                        </label>



                        @if($project->status == "requested")
                        <a href="{{url("user/project/initiate-offer-chat/".$project->id."/".$project->invoice_number."")}}"><button class="flex mx-2 btn btn-outline-success">Request an Offer</button></a>
                        @endif

                        @if(in_array($project->status , ["offer_accepted", "project_submitted"]))
                        <a href="{{url("user/project/initiate-offer-chat/".$project->id."/".$project->invoice_number."")}}"><button class="flex mx-2 btn btn-outline-success">Update your Offer</button></a>
                        @endif


                        <button class="flex ml-5 btn btn-outline-danger">
                            <i class="fa fa-document"></i>
                            Cancel Project</button>

                    </div>
                    <div class="type_msg">

                        <div class="col-12 mt-1 p-1 bg-white d-inline-flex">
                            <a href="javascript:void(0)" class="flex mr-2"><i class="fa fa-smile"></i></a>

                        </div>
                    </div>
                </div>
                <div class="files"  >
                    <div id="accordion">
                        <div class="card">
                            <div class="bg-white" id="headingOne">
                                <button class="btn btn-lg btn-block text-align-left" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa fa-file-text"></i> Files
                                </button>
                            </div>

                            <div id="collapseOne" class="collapse"  style="max-height: 60vh; overflow-y: auto" aria-labelledby="headingOne"
                                data-parent="#accordion" >
                                <div class="bg-white">
                                    <div class="table-responsive" >


                                        <table class="table table-bordered" id="fileTable">
                                            <thead>
                                                <tr>
                                                    <td style="width: 50%">File</td>
                                                    <td style="width: 50%">Sender</td>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <tr>
                                                    <td>
                                                        <a target="_blank" class="text-primary"
                                                            href="{{ url('public/storage/' . $project->document) }}">
                                                            {{ substr(str_replace('documents/', '', $project->document), 0, 10) }}..
                                                        </a>
                                                    </td>
                                                    <td>
                                                        Me
                                                    </td>
                                                </tr>
                                                @foreach ($files as $file)
                                                    <tr>
                                                        <td>
                                                            <a target="_blank" class="text-primary"
                                                                href="{{ url('public/storage/' . $file->message) }}">
                                                                {{ substr(str_replace('documents/', '', $file->message), 0, 10) }}..
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if ($file->sender == Auth::id())
                                                                {{ 'Me' }}
                                                            @else
                                                            {{"Acelocale"}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>



                            <div class="bg-white" id="headingTwo">
                                <button class="btn btn-lg btn-block text-align-left" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <i class="fa fa-tasks"></i> Project
                                </button>
                            </div>

                            <div id="collapseTwo" class="collapse" aria-labelledby="collapseTwo"
                                data-parent="#accordion">

                                <div class="alert">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Title</td>
                                                <td>{{ $project->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <label class="btn badge-primary">
                                                        {{ $project->status }}
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>{{ $project->description }}</td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>{{ $project->department }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course Name</td>
                                                <td>{{ $project->course_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Start Time</td>
                                                <td>{{ $project->start_time }}</td>
                                            </tr>
                                            <tr>
                                                <td>End Time</td>
                                                <td>{{ $project->end_time }}</td>
                                            </tr>

                                          

                                        </tbody>

                                    </table>
                                   
                                </div>
                            </div>


                            <div class="bg-white" id="headingSubmit">
                                <button class="btn btn-lg btn-block text-align-left" data-toggle="collapse"
                                    data-target="#collapseSubmit" aria-expanded="true" aria-controls="collapseSubmit">
                                    <i class="fa fa-file-text"></i> Project Submitted Files
                                </button>
                            </div>

                            <div id="collapseSubmit" class="collapse"  style="max-height: 60vh; overflow-y: auto" aria-labelledby="headingSubmit"
                                data-parent="#accordion" >
                                <div class="bg-white">
                                    <div class="table-responsive" >


                                        <table class="table table-bordered" id="fileTableSubmit">
                                            <thead>
                                                <tr>
                                                    <td style="width: 50%">File</td>
                                                </tr>
                                            </thead>
                                            <tbody >
                                               
                                                @foreach ($filesSubmitted as $file)
                                                    <tr>
                                                        <td>
                                                            <a target="_blank" class="text-primary"
                                                                href="{{ url('public/storage/' . $file->message) }}">
                                                                {{  $file->message }}
                                                            </a>
                                                        </td>
                                                       
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        @include('components.file-preview')
        @include('components.chat-js')
    @endsection

