<?php

namespace App\Http\Controllers;

use App\Models\SubAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class SubAdminController extends Controller
{

 public function __construct()
    {
        $this->user = new SubAdmin();
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['subadmin'] = SubAdmin::where('role_id','2')->get();
        return view('admin.adminPanel.sub_admin.view',$data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.adminPanel.sub_admin.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     

       $users=Auth::id();

      // dd($user);
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

            $data = [];

            $data['name'] = $request->name;
            $data['email']      = strtolower(trim($request->email));
            $data['password']   = bcrypt($request->password);
            $data['status']  = 1;
            $data['role_id'] = 2;
            $data['created_by'] = $users['id'];
            $data['updated_by'] = $users['id'];

            $user = SubAdmin::create($data);

            return response()->json(['success' => __('Data Added successfully.'),$user]);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.adminPanel.sub_admin.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamLeads  $teamLeads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = SubAdmin::where('id',$id)->first();
        
        return view("admin.adminPanel.sub_admin.edit",compact('user'));
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
        //dd('sdasad');
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
     
        SubAdmin::where('id', $id)->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password'=>bcrypt($request->password),
                
            ]
        );

        return redirect("admin/subAdmin/index")
        ->with("success",'SuperAdmin is updated');
        
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
        $user = SubAdmin::find($request->id);
        $user->delete();
        return response(['message' => 'SubAdmin delete successfully']);


    }
}
