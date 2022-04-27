<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public static function getUserProject($user_id){
        return Project::where('user_id', $user_id)->orderBy('id', 'desc')->get();
    }
    
    public static function getTeamleadProject($user_id){
        return Project::where('manager_id', $user_id)->orderBy('id', 'desc')->get();
    }

    public static function getProjectByStatus($user_id, $status){
        return Project::where('user_id', $user_id)->orderBy('id', 'desc')->whereIn('status', $status)->get();
    }

    public static function getAllProjects(){
        return Project::orderBy('id', 'desc')->get();
    }

    public static function getUserProjectWithId($user_id, $project_id){
        return Project::where('user_id', $user_id)->where('id', $project_id)->first();
    }

    public static function getTeamLeadProjectWithId($user_id, $project_id){
        return Project::where('manager_id', $user_id)->where('id', $project_id)->first();
    }

    public static function storeProject($array){
        return Project::insertGetId($array);
    }

    public static function updateProject($array, $id){
         Project::where('id', $id)->update($array);
         return $id;
    }

    public static function deleteProject($id){
         Project::where('id', $id)->delete();        
         return true;
    }

    public function customer()
    {
        return $this->belongsTo(subAdmin::class, 'user_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(subAdmin::class, 'manager_id', 'id');
    }
}
