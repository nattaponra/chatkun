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
    private $userModel;
    public function __construct(array $attributes = [])
    {
        $this->chatKunMessageModel = App::make(ChatKunMessage::class);
        $this->userModel           = App::make(User::class);
        parent::__construct($attributes);
    }

    public function fromUser()
    {
        return $this->hasOne("App\User", "id", "user_id");
    }

    /** @param string $from
     *  @param  string $to
     *  @param  string $message
     */
    private function sendMessageToService($from, $to, $message)
    {
        $chatKunFactory = new ChatKunFactory();
        $chatKunService = $chatKunFactory->getChatService(config("chatkun.default_service", ""));
        $chatKunService->sendMessage($from, $to, $message);
    }

    /** @param \App\User $toUser
     *  @param  \Nattaponra\chatkun\ChatKunMessage $chatKunMessage
     *
     */
    public function sendMessage(User $toUser,ChatKunMessage $chatKunMessage)
    {

        //Create initial message
        if(!$this->hasInitialMessage($toUser)){
            $this->createInitialMessage($toUser);
        }


        //Save message to database.
        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $toUser->id;
        $chatKunMessage->save();

        foreach ($chatKunMessage->getSubMessages() as $subMessage){

            //Send message to service.
             $this->sendMessageToService($this->fromUser->id, $toUser->id, $subMessage->getMessage());

            //Save sub message to database.
            $subMessage->messages_id = $chatKunMessage->id;
            $subMessage->save();
       }

    }

    private function createInitialMessage(User $toUser){

        $chatKunMessage             = new ChatKunMessage();
        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $toUser->id;
        $chatKunMessage->save();

        $subMessage = new ChatKunSubMessage();
        $subMessage->setMessage("initial_message");
        $subMessage->setSubMessageType("initial_message");
        $subMessage->messages_id = $chatKunMessage->id;
        $subMessage->save();
    }


    private function hasInitialMessage(User $toUser){

        $count = $this->chatKunMessageModel->where("to_user_id",$toUser->id)->whereHas("subMessages",function($query){
            $query->where("sub_message_type","initial_message");
        })->count();

        return $count == 1 ? true:false;
    }

    public function getMyContact()
    {
        $userId   = $this->fromUser->id;
        //Send to
        $results = $this->chatKunMessageModel->where(function($query) use ($userId){

            $query->where("user_id",$userId);
            $query->orWhere('to_user_id',$userId);

        })->whereHas("subMessages",function($query){

            $query->where("sub_message_type","initial_message");

        })->get();

        $userIds = [];
        foreach ($results as $result){

            if($result->to_user_id != $userId){
                $userIds[] = $result->to_user_id;
            }

            if($result->user_id != $userId){
                $userIds[] = $result->user_id;
            }

        }

        return $this->userModel->whereIn("id",$userIds)->get();

    }


}






