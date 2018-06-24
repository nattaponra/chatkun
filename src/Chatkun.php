<?php

namespace nattaponra\chatkun;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ChatKun extends Model
{
    protected $table = "chatkun";
    protected $fillable = ["user_id"];
    private $chatKunMessageModel;

    public function __construct(array $attributes = [])
    {
        $this->chatKunMessageModel = App::make(ChatKunMessage::class);
        parent::__construct($attributes);
    }

    public function fromUser()
    {
        return $this->hasOne("App\User", "id", "user_id");
    }

    private function sendMessageToService($from, $to, $message)
    {
        $chatKunFactory = new ChatKunFactory();
        $chatKunService = $chatKunFactory->getChatService(config("chatkun.default_service", ""));
        $chatKunService->sendMessage($from, $to, $message);
    }

    public function sendMessage(User $toUser,ChatKunMessage $chatKunMessage)
    {

        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $toUser->id;
        $chatKunMessage->save();

       foreach ($chatKunMessage->getSubMessages() as $subMessage){
            $subMessage->messages_id = $chatKunMessage->id;
            $subMessage->save();
       }
        //Send message to service
//        $this->sendMessageToService($this->fromUser->id, $user->id, $chatKunSubMessage->getMessage());
//
//        //Save message to database
//        $chatKunMessage = ChatKunMessage::create([
//            'user_id'    => $this->fromUser->id,
//            'to_user_id' => $user->id
//        ]);
//
//        $chatKunSubMessage->save();
//
//        return $chatKunMessage;
    }


    public function getMyContact()
    {
       // $this->chatKunMessageModel->where("user_id",);
        return  ;
    }


}






