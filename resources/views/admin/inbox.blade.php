@extends('layouts.app')

@section('content')
    <link href="{{ url('/') }}/assets/css/message.css" rel="stylesheet">


    <div class="container-fluid w-100">
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
                            <a href="{{ url('admin/project/messages/' . $item->id . '/' . $item->invoice_number) }}">
                                <div class="chat_list">
                                    <div class="chat_people">
                                        <div class="chat_img"> <img
                                                src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                        <div class="chat_ib">
                                            <h5>{{ $item->title }} <span
                                                    class="chat_date">{{ date('d M', strtotime($item->created_at)) }}</span>
                                            </h5>
                                            <small>
                                                {{substr(\App\Models\Messages::getLastMessage($item->id),0,30) }}...
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
                <div class="mesgs">

                </div>
                <div class="files" style="height: 60vh">
                  
                </div>


            </div>

        </div>
    @endsection

