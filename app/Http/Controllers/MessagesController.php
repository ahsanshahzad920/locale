<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Exception;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Messages::insert(
            [
                'message' => $request->message,
                'sender' => $request->sender,
                'message_type' => $request->message_type,
                'read_status' => 0,
                'project_id' => $request->project_id
            ]
        );
        return response(['message' => 'msg sent'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }


    public function recieve(Request $request)
    {
        if ($request->project_id != "") {
            return response([
                'messages' => Messages::where('project_id', $request->project_id)->orderBy('id', 'desc')->whereIn('message_type',['text','file','file_submit'])->first(),
                'messagesCount' => Messages::where('project_id', $request->project_id)->orderBy('id', 'desc')->whereIn('message_type',['text','file','file_submit'])->count()
            ], 200);
        }
    }
    public function recieve_offer_chat(Request $request)
    {
        if ($request->project_id != "") {
            return response([
                'messages' => Messages::where('project_id', $request->project_id)->orderBy('id', 'desc')->whereIn('message_type',['offer_message','offer'])->first(),
                'messagesCount' => Messages::where('project_id', $request->project_id)->orderBy('id', 'desc')->whereIn('message_type',['offer_message','offer'])->count()
            ], 200);
        }
    }


    public function uploadFiles($pid, $uid, Request $request)
    {
        $i = 0;
        $files  = []; $filename = "";
        try {
            // while ($request->hasFile("file")) {
                // array_push($files, $request->file("file"));
            
               $filename =  $request->file('file')->storeAs('documents',$request->file("file")->getClientOriginalName()."_".time().".".$request->file('file')->getClientOriginalExtension(),'public');
                Messages::insert(
                    [
                        'message' => $filename,
                        'sender' => $request->sender,
                        'message_type' => isset($request->isSubmit)?"file_submit":'file',
                        'read_status' => 0,
                        'project_id' => $request->project_id
                    ]
                );

                if($request->has("isSubmit")){
                    Project::where("id", $request->project_id)->update(['status'=>'project_submitted']);
                }
               
            // };

            return response(['message' => 'files are uploaded', 'file' => $filename, 'project_status'=>isset($request->isSubmit)?"project_submitted":''], 200);
        } catch (Exception $e) {
            return response(['message' => 'files error ', 'error' => $e->getMessage()], 401);
        }
    }
}
