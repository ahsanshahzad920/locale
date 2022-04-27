<?php

namespace App\Models;

use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    public static function getLastMessage($id){
        return Messages::where("project_id" ,$id)->orderBy("id","desc")->first()->message ?? "--";
    }
}
