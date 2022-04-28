<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Feedback;
use App\Models\TeamLeads;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['data'] = Feedback::where('role_id','4')->get();
        return view('admin.adminPanel.Feedback.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.adminPanel.feedbacks.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'option0' => 'required'
            ]
        );
        $size = count(collect($request)->get('question'));
        // dd($size-1);
        if($size<10){
        $data = $request->all();
        $client=TeamLeads::where('role_id','3')->get();
        // for($i=0; $i<=$size-1; $i++){
            
        //     $feedback = new Feedback;
        //     $feedback->question = $request->question[$i];
        //     $feedback->option = json_encode($data['option'.$i]);
        //     $feedback->client_id = Auth()->user()->id;
        //     $feedback->save();
        // }
    }else{
        return back()->with('error','Questions are greater then 10!');
    }
    return view('admin.adminPanel.feedbacks.client_feedback',compact('data','client'));
        
    }
    public function client_feedback(Request $request)
    {
        
        $size = count(collect($request)->get('question'));
        $data = $request->all();
       
        for($i=0; $i<=$size-1; $i++){
            
            $feedback = new Feedback;
            $feedback->question = $request->question[$i];
            $feedback->option = $data['option1'.$i]??'';
            $feedback->option1 = $data['option2'.$i]??'';
            $feedback->option2 = $data['option3'.$i]??'';
            $feedback->option3 = $data['option4'.$i]??'';
            $feedback->client_id =json_encode($data['client_id']);
            $feedback->save();
        }
        return redirect('admin/feedback/create')->with('success','Feedback add for client!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = Feedback::where('id',$id)->first();
        
        return view("admin.adminPanel.teamleads.edit",compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
     
        Feedback::where('id', $id)->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password'=>bcrypt($request->password),
            ]
        );
        return redirect("admin/teamlead/index")
        ->with("success",'TeamLead is updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $teamLeads
     * @return \Illuminate\Http\Response
     */
   
    public function delete(Request $request)
    {
        //dd($request->all());
        $user = Feedback::find($request->id);
        $user->delete();
        return response(['message' => 'SubAdmin delete successfully']);


    }
}
