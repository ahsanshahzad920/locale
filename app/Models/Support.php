<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    protected $table = "support";

      protected $fillable = [
        'sender_id',
        'receiver_id',
        'titile',
        'message',
        'reply'
    ];

    public function sender()
    {
        return $this->belongsTo(subAdmin::class, 'sender_id', 'id');
    }

}
