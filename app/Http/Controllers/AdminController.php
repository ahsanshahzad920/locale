<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Project;


class AdminController extends Controller
{
    //

    public function inbox(){
        $data['projects'] = Project::getAllProjects();
      
        return view('admin.inbox', $data);    
    }
}
