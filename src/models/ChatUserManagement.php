<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUserManagement extends Model
{
    protected $fillable = [
        'resource_id', 'user_id'
    ];
}
