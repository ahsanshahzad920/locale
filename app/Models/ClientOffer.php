<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'price',
        'currency',
        'time',
        'time_unit'
    ];
}
