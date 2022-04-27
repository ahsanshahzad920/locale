<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'chat_messages';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'sender_id', 'receiver_id', 'chat_id', 'request_id', 'read'
    ];
    
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
    
    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }
}
