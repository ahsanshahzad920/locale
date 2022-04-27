<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Support;
use App\Models\Chat;
use App\Models\Messages;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['data'] = Chat::where('user1_id',Auth::user()->id)->with(['user2'])->get();
        //dd($data['data']);
        return view('admin.adminPanel.support.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['data'] = Support::where('sender_id',Auth::user()->id)->with(['sender'])->get();
     
        return view('admin.adminPanel.support.admin',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),
        [
            'receiver_id' => 'required',
            'titile' => 'required',
            'message'      => 'required',
        ]
    );

    if ($validator->fails())
    {
        return response()->json(['errors' => $validator->errors()->all()]);
    }
        Support::insert(
            [
                'sender_id' => Auth::user()->id,
                'receiver_id' => $request->email,
                'titile' => $request->titile,
                'message'=>$request->message,
               
            ]
        );

        return redirect("admin/support/index")
        ->with("success",'Team Lead is created, default password is acelocale123');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['data'] = TeamLeads::find($id);
        return view("admin.teamleads.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        TeamLeads::where('id', $id)->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                
            ]
        );

        return redirect("admin/teamleads/edit/$id")
        ->with("success",'Team Lead is updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        TeamLeads::where("id", $id)->delete();

        return redirect("admin/teamleads/index")
        ->with("danger",'Team Lead is removed');


    }
}
