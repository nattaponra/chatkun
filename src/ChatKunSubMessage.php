<?php


namespace nattaponra\chatkun;
use Illuminate\Database\Eloquent\Model;

class ChatKunSubMessage extends Model
{
    protected $fillable = ["messages_id","sub_message_type","message"];
    protected $table    = "chatkun_sub_messages";


    public function setSubMessageType($subMessageType){
        $this->sub_message_type = $subMessageType;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getSubMessageType(){
        return $this->sub_message_type;
    }

    public function getMessage(){
        return $this->message ;
    }
}