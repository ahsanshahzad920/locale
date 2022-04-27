<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Messages;
use App\Models\TeamLeads;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!isset($_GET['status']))
        $data['data']  = Project::getUserProject(Auth::id());
        else
        $data['data']  = Project::getProjectByStatus(Auth::id(), [$_GET['status'] ] );

        

        return view('projects.index', $data);
    }


    public function index_teamlead()
    {
        //
        if(!isset($_GET['status']))
        $data['data']  = Project::getTeamleadProject(Auth::id());
        else
        $data['data']  = Project::getProjectByStatus(Auth::id(), [$_GET['status'] ] );

        

        return view('teamlead.projects', $data);
    }


    public function get_all(){
        return response(['projects'=>Project::all()], 200);
    }
    public function get($user_id){
        return response(['projects'=>Project::getUserProject($user_id)], 200);
    }

    public function get_with_id($user_id, $project_id){
        if(Project::where('id',$project_id)->where('user_id', $user_id)->exists())
        return response(['projects'=>Project::getUserProjectWithId($user_id, $project_id)], 200);
        else
        return response(['message'=>"Not found"], 404);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('projects.create');
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
        $document  = ""; $invoice_number = "";
        $user_id = Auth::id();
        if($request->has("user_id")){
            $user_id = $request->user_id;
        }


        if($request->hasFile('document')){
            $document = $request->file('document')->store('documents', 'public');
        }
        $invoice_number = time().$user_id;
        $array = [
            'title'=>$request->title,
            'invoice_number'=>$invoice_number,
            'department'=>$request->department,
            'course_name'=>$request->course_name,
            'description'=>$request->description,
            'status'=>'requested',
            'user_id'=>$user_id,
            'document'=>$document,
        ];
        $project_id = Project::storeProject($array);
        if($project_id){

            if($request->has('response_method') && $request->response_method == "api"){
                return response(['message'=>'saved', 'project_id'=>$project_id,'invoice_number'=>$invoice_number], 200);
            }
            echo "saved";
            return redirect('user/project/messages/'.$project_id."/".$invoice_number);
        }
    }


    public function messages($id, $invoice){
        $data['project'] =$this->accessValidProjectInformation($id, $invoice);

        $data['projects'] = Project::getUserProject(Auth::id());
        $data['project_id'] = $id;
        $data['messages'] = Messages::where('project_id', $id)->whereIn('message_type',['text','file','project_submit'])->get();
        $data['files'] = Messages::where("message_type",'file')->where('project_id', $id)->get();
        $data['filesSubmitted'] = Messages::where("message_type",'file_submit')->where('project_id', $id)->get();


        return view('projects.messages', $data);
    }



    public function messages_admin($id, $invoice){
        $data['project'] = $this->accessValidProjectInformation($id, $invoice);

        $data['projects'] = Project::getAllProjects();
        $data['project_id'] = $id;
        $data['teamleads'] = TeamLeads::where("role","teamlead")->get();
        $data['messages'] = Messages::where('project_id', $id)->whereIn('message_type',['text','file','project_submit'])->get();
        $data['files'] = Messages::where("message_type",'file')->where('project_id', $id)->get();

        $data['filesSubmitted'] = Messages::where("message_type",'file_submit')->where('project_id', $id)->get();

        return view('admin.messages', $data);
    }




    

    public function messages_teamlead($id, $invoice){
        $data['project'] = $this->accessValidProjectInformation($id, $invoice);

        $data['projects'] = Project::getTeamleadProject(Auth::id());
        $data['project_id'] = $id;
        $data['teamleads'] = TeamLeads::where("role","teamlead")->get();
        $data['messages'] = Messages::where('project_id', $id)->whereIn('message_type',['text','file','project_submit'])->get();
        $data['files'] = Messages::where("message_type",'file')->where('project_id', $id)->get();
        $data['filesSubmitted'] = Messages::where("message_type",'file_submit')->where('project_id', $id)->get();


        return view('teamlead.messages', $data);
    }


    public function initiateOffer($id, $invoice){
        Project::where('id', $id)->where('invoice_number', $invoice)->update(['status'=>'offer_requested']);
        event(new \App\Events\OfferNotification(url('admin/project/offer-chat/'.$id.'/'.$invoice)));

        return redirect('user/project/offer-chat/'.$id.'/'.$invoice)->with('success','Offer request is sent, wait for the admin to response your request');

    }
    public function messages_offer_chat($id, $invoice){
       $data['project'] = $this->accessValidProjectInformation($id, $invoice);
        $data['project_id'] = $id;
        $data['messages'] = Messages::where('project_id', $id)->whereIn('message_type',['offer_message','offer'])->get();
        return view('projects.offer-chat', $data);
    }

    public function messages_offer_chat_admin($id, $invoice){
        $data['project'] = $this->accessValidProjectInformation($id, $invoice);
         $data['project_id'] = $id;
         $data['messages'] = Messages::where('project_id', $id)->whereIn('message_type',['offer_message','offer'])->get();
         return view('admin.offer-chat', $data);
     }


    
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $project_id)
    {
        $document  = ""; 
        $array = [
            'title'=>$request->title,
            'department'=>$request->department,
            'course_name'=>$request->course_name,
            'description'=>$request->description,
            'status'=>'requested',
            
        ];
        if($request->hasFile('document')){
            $document = $request->file('document')->store('documents', 'public');
            $array['document']=$document;
        }
        
        $project_id = Project::updateProject($array, $project_id);
        if($project_id){

            if($request->has('response_method') && $request->response_method == "api"){
                return response(['message'=>'updated','project'=>Project::find($project_id), 'project_id'=>$project_id], 200);
            }
            echo "saved";
            return redirect('user/projects');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id)
    {
        //
        Project::where('id', $project_id)->delete();

        return response(['message'=>'deleted', 'project_id'=>$project_id], 200);
    }


    public function assignTeamLead($project_id, Request $request){
        Project::where('id', $project_id)->update(['manager_id'=>$request->teamlead]);
        if($request->teamlead == "")
        return response(['message'=>"Project Team is not assigned"], 200);
        else
        return response(['message'=>"Project is assigned to ".(User::find($request->teamlead)->name)], 200);

    }


    public function accessValidProjectInformation($id, $invoice){

        $project_data = Project::where('id', $id)->first();

        if(!Project::where('id', $id)->where('invoice_number', $invoice)->exists()){
            abort(404);
        }
       

        if(Auth::user()->role == "client"){
            if($project_data->user_id != Auth::id()){
            abort(403);
        }
        }

        return $project_data;
    }
}
