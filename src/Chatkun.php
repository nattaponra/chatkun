<?php

namespace nattaponra\chatkun;


use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKun extends Model
{
    protected $table = "chatkun";
    protected $fillable = ["user_id"];

    public function fromUser(){
        return $this->hasOne("App\User","id","user_id");
    }

    public function sendMessage(User $user,  $message){
        $chatKunMessage = ChatKunMessage::create([
            'user_id'    => $this->fromUser->id,
            'to_user_id' => $user->id
        ]);


        ChatKunSubMessage::create([
            'messages_id'        => $chatKunMessage->id,
            'sub_message_type'   => "message",
            'message'            => $message
        ]);

        return $chatKunMessage;
    }






}