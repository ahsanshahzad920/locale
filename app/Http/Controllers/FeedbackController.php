<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Feedback;
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
        $data['data'] = TeamLeads::where('role_id','4')->get();
        return view('admin.adminPanel.teamleads.view',$data);
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
        dd($request->all());
        $users=Auth::id();
        $validator = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'email'      => 'required|email|unique:users',
                ]
            );
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }    
        TeamLeads::insert(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id'=>'4',
                'email_verified_at'=>now(),
                'status'  => 1,
                'created_by' => $users,
                'updated_by' => $users,
            ]
        );

        return redirect("admin/teamlead/index")
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
        
        $user = TeamLeads::where('id',$id)->first();
        
        return view("admin.adminPanel.teamleads.edit",compact('user'));
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
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
     
        TeamLeads::where('id', $id)->update(
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
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
   
    public function delete(Request $request)
    {
        //dd($request->all());
        $user = TeamLeads::find($request->id);
        $user->delete();
        return response(['message' => 'SubAdmin delete successfully']);


    }
}
