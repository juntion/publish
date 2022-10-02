<?php


namespace App\Models;

use App\Models\BaseModel;

class LiveChatAdmin extends BaseModel
{
    protected $table = "live_chat_admin";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
