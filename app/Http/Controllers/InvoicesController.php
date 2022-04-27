<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data['data'] = Project::with(['customer','manager'])->get();
         //dd($data['data']);
        return view('admin.adminPanel.invoices.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.teamleads.create");
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
        TeamLeads::insert(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt("acelocale123"),
                'role'=>'teamlead',
                'email_verified_at'=>now()
            ]
        );

        return redirect("admin/teamleads/index")
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
        $data['data'] = Project::where('id',$id)->with(['customer','manager'])->first();
        return view("admin.adminPanel.invoices.invoice_details",$data);

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
