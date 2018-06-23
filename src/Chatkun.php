<?php

namespace nattaponra\chatkun;


use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKun extends Model
{
    protected $table    = "chatkun";
    protected $fillable = ["user_id"];

    public function fromUser(){
        return $this->hasOne("App\User","id","user_id");
    }

    private function sendMessageToService($from,$to,$message)
    {
        $chatKunFactory  = new ChatKunFactory();
        $chatKunService  = $chatKunFactory->getChatService(config("chatkun.default_service",""));
        $chatKunService->sendMessage($from,$to,$message);
    }

    public function sendMessage(User $user,  $message){

        //Send message to service
        $this->sendMessageToService($this->fromUser->id, $user->id, $message);

        //Save message to database
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






