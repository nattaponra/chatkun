<?php


namespace nattaponra\chatkun;
use Illuminate\Database\Eloquent\Model;

class ChatKunSubMessage extends Model
{
    protected $fillable = ["messages_id","sub_message_type","message"];
    protected $table    = "chatkun_sub_messages";

}