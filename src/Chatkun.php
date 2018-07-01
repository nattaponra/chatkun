<?php

namespace nattaponra\chatkun;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ChatKun extends Model
{
    protected $table = "chatkun";
    protected $fillable = ["user_id","last_online"];
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
    private function sendMessageToService(User $user, $to, $message)
    {
        $chatKunFactory = new ChatKunFactory();
        $chatKunService = $chatKunFactory->getChatService(config("chatkun.default_service", ""));
        $chatKunService->sendMessage($user, $to, $message);
    }

    /** @param \App\User $toUser
     *  @param  \Nattaponra\chatkun\ChatKunMessage $chatKunMessage
     *
     */
    public function sendMessage(User $toUser,ChatKunMessage $chatKunMessage)
    {
        //Get Message
        $subMessage = $chatKunMessage->getSubMessage();

        //Send message to service.
        $this->sendMessageToService($this->fromUser, $toUser->id, $subMessage->getMessage());


        //Create initial message
        if(!$this->hasInitialMessage($toUser)){
            $this->createInitialMessage($toUser);
        }

        //Save message to database.
        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $toUser->id;
        $chatKunMessage->chat_type  = "user_to_user";
        $chatKunMessage->save();

        //Save sub message to database.

        $subMessage->messages_id = $chatKunMessage->id;
        $subMessage->save();



    }

    private function createInitialMessage(User $toUser){

        $chatKunMessage             = new ChatKunMessage();
        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $toUser->id;
        $chatKunMessage->chat_type  = "initial_message";
        $chatKunMessage->save();

        $subMessage = new ChatKunSubMessage();
        $subMessage->setMessage("initial_message");
        $subMessage->setSubMessageType("initial_message");
        $subMessage->messages_id = $chatKunMessage->id;
        $subMessage->save();
    }


    private function hasInitialMessage(User $toUser){

        $count = $this->chatKunMessageModel->where("to_user_id",$toUser->id)->whereHas("subMessage",function($query){
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
        $userIds = array_unique($userIds);
        return $this->userModel->whereIn("id",$userIds)->get();

    }

    public function getChatHistories(User $toUser){

        $myUserId        = $this->fromUser->id;
        $contactUserId   = $toUser->id;

        $messages = $results = $this->chatKunMessageModel
             ->where(function($query) use($myUserId,$contactUserId){
                $query->where("user_id",$myUserId)->where("to_user_id",$contactUserId)->where("chat_type","!=","initial_message");
             })->orWhere(function($query) use($myUserId,$contactUserId){
                $query->where("to_user_id",$myUserId)->where("user_id",$contactUserId)->where("chat_type","!=","initial_message");
        })->orderBy("created_at","ASC")->get();


        return $messages;
    }

    public function sendMessageGroup($groupId, ChatKunMessage $chatKunMessage){

        //Get Message
        $subMessage = $chatKunMessage->getSubMessage();

        //Send message to service.
        $this->sendMessageToService($this->fromUser, $groupId, $subMessage->getMessage());



        //Save message to database.
        $chatKunMessage->user_id    = $this->fromUser->id;
        $chatKunMessage->to_user_id = $groupId;
        $chatKunMessage->chat_type  = "group";
        $chatKunMessage->save();

        //Save sub message to database.
        $subMessage->messages_id = $chatKunMessage->id;
        $subMessage->save();
    }


    public function getChatGroupHistories($groupId){

       return $this->chatKunMessageModel
            ->where("chat_type","group")
            ->where("to_user_id",$groupId)
            ->whereHas("subMessage",function($query){
               $query->whereNotNull("id");
             })->with("subMessage")->orderBy("id","ASC")->get();


    }


    public function getLastMessage(User $contactUser){
        $myUserId        = $this->fromUser->id;
        $contactUserId   = $contactUser->id;

        $fromMessages = $results = $this->chatKunMessageModel
            ->where("user_id",$contactUserId)
            ->where("to_user_id",$myUserId)
            ->where("chat_type","!=","initial_message")
            ->with("subMessage")
            ->first();


        $toMessages = $results = $this->chatKunMessageModel
                ->where("user_id",$myUserId)
                ->where("to_user_id",$contactUserId)
                ->where("chat_type","!=","initial_message")
                ->with("subMessage")
                ->first();

        if(empty($fromMessages)){

            if(!empty($toMessages)){

                return $toMessages;
                
            }else{
                return "";
            }

        }else{
            return $fromMessages;
        }
    }

}






