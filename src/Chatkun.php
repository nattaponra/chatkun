<?php

namespace nattaponra\chatkun;



use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ChatKun
{
    private $chatKunRoomModel;
    private $chatKunMessageModel;
    private $chatKunRoomMemberModel;
    private $chatKunMessageStatusModel;
    private $chatKunFactory;

    /**
     * ChatKun constructor.
     * @param ChatKunRoom $chatKunRoom
     * @param ChatKunMessage $chatKunMessage
     * @param ChatKunRoomMember $chatKunRoomMember
     * @param ChatKunMessageStatus $chatKunMessageStatus
     * @param ChatKunFactory $chatKunFactory
     */

    public function __construct(ChatKunRoom $chatKunRoom,ChatKunMessage $chatKunMessage,ChatKunRoomMember $chatKunRoomMember,ChatKunMessageStatus $chatKunMessageStatus,ChatKunFactory $chatKunFactory)
    {
        $this->chatKunFactory            = $chatKunFactory;
        $this->chatKunRoomModel          = $chatKunRoom;
        $this->chatKunMessageModel       = $chatKunMessage;
        $this->chatKunRoomMemberModel    = $chatKunRoomMember;
        $this->chatKunMessageStatusModel = $chatKunMessageStatus;
    }

    /**
     * @param  string $name
     * @param  string $roomType
     * @return Model|ChatKunRoom
     */
    public function createRoom($name,$roomType){

        return $this->chatKunRoomModel->create([
            'name' => $name,
            'room_type' => $roomType
        ]);
    }

    /**
     * @param integer $roomId
     * @return \Illuminate\Database\Eloquent\Collection|Model|ChatKunRoom|ChatKunRoom[]|null
     */
    public function findRoom($roomId){
        return $this->chatKunRoomModel->find($roomId);
    }

    /**
     * @param User $user
     * @param ChatKunRoom $chatKunRoom
     * @return Model|ChatKunRoomMember|null
     */
    public function addMember(User $user,ChatKunRoom $chatKunRoom){

        $member = $this->chatKunRoomMemberModel->where("user_id",$user->id)->where("room_id",$chatKunRoom->id)->first();
        if(empty($member)){
            return $this->chatKunRoomMemberModel->create([
                'room_id' => $chatKunRoom->id,
                'user_id' => $user->id,
                'role'    => ''
            ]);
        }

        return $member;
    }

    /**
     * @param User $user
     * @param ChatKunRoom $chatKunRoom
     * @param $messageType
     * @param $messageContent
     * @return Model|ChatKunMessage
     */
    public function send(User $user,ChatKunRoom $chatKunRoom ,$messageType, $messageContent)
    {


        $message = $this->chatKunMessageModel->create([
            'user_id' => $user->id,
            'room_id' => $chatKunRoom->id,
            'message_type' => $messageType,
            'message_content' => $messageContent
        ]);


        $chatKunRoomMembers = $this->chatKunRoomMemberModel->where("room_id", $chatKunRoom->id)->where("user_id", "!=", $user->id)->get();

        foreach ($chatKunRoomMembers as $member){
            $this->chatKunMessageStatusModel->create([
                'message_id' => $message->id,
                'user_id'    => $member->user_id,
                'status'     => "unread",
            ]);
        }

       $chatKunService = $this->chatKunFactory->getChatService(config("chatkun.default_service", ""));
       $chatKunService->sendMessage($message);

        return $message;
    }

    /**
     * @param integer $roomId
     * @param integer $messagePerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function history($roomId,$messagePerPage){
        $history =  $this->chatKunMessageModel->where("room_id",$roomId)->orderBy("id","DESC")->paginate($messagePerPage);
        $history = $history->sortBy("id");

        return $history;
    }

    /**
     * @param User $me
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getContacts(User $me){

        $rooms =  $this->chatKunRoomMemberModel->where("user_id",$me->id)->get();
        $roomIds = [];

        foreach ($rooms as $room){
            $roomIds[] = $room->room_id;
        }

        $roomMembers =  $this->chatKunRoomMemberModel->whereIn("room_id",$roomIds)->where("user_id","!=",$me->id)->get();

        $memberIds = [];
        foreach ($roomMembers as $roomMember){
            $memberIds[] = $roomMember->user_id;
        }

        return User::whereIn("id",$memberIds)->get();
    }

    /**
     * @param $roomType
     * @param User $me
     * @param User $contactUser
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|Model|mixed|ChatKunRoom|ChatKunRoom[]|ChatKunRoomMember|null
     */

    public function generateRoomByUser($roomType, User $me, User $contactUser){

        $rooms =  $this->chatKunRoomMemberModel->whereHas('room', function ($query) use ($roomType) {
            $query->where('room_type',$roomType);
        })->where("user_id",$me->id)->get();

        $roomIds = [];

        foreach ($rooms as $room){
            $roomIds[] = $room->room_id;
        }
         
        $room =  $this->chatKunRoomMemberModel->whereHas('room', function ($query) use ($roomType) {
            $query->where('room_type',$roomType);
        })->whereIn("room_id",$roomIds)->where("user_id",$contactUser->id)->first();

        if(empty($room)){
            $room = $this->createRoom("ROOM_".$me->id."_".$contactUser->id, $roomType);
            $this->addMember($me,$room);
            $this->addMember($contactUser,$room);

        }else{
            $room = $this->chatKunRoomModel->find($room->room_id);
        }

        return $room;
    }

    /**
     * @param User $me
     * @return int
     */
    public function getUnreadMessageCount(User $me){

        $unreadMessages =  $this->chatKunMessageStatusModel->whereHas("message")->where("user_id",$me->id)->where("status","unread");
        return $unreadMessages->count();
    }

    /**
     * @param $roomId
     * @param User $me
     */
    public function makeRead($roomId,User $me){
        $this->chatKunMessageStatusModel->whereHas("message",function($query) use ($roomId){
            $query->where("room_id",$roomId);
        })->where("user_id",$me->id)->where("status","unread")->update(["status" => "read"]);
    }

}






