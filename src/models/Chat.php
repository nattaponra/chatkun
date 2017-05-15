<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later


        $this->clients->attach($conn);


        $chatUserManagement=  ChatUserManagement::where("resource_id",$conn->resourceId);
         if($chatUserManagement->count()==0){
             ChatUserManagement::create(array('resource_id'=>$conn->resourceId,'user_id'=>99999999));
         }
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $input=json_decode($msg);
         if($input->to_user_id=="connect"){

             ChatUserManagement::where("resource_id",$from->resourceId)->update(['user_id'=>$input->user_id]);
         }else{
             ChatMessage::create(array('user_id'=>$input->user_id,'to_user_id'=>$input->to_user_id,'message'=>$input->message,'status'=>'unread'));
             /**  Find resourceId By user_id*/
            $receiverData= ChatUserManagement::where("user_id",$input->to_user_id)->get();
             if($receiverData->count()!=0){
                 print_r($receiverData[0]->resource_id);
                 foreach ($this->clients as $client) {
                     if ($client->resourceId==$receiverData[0]->resource_id) {
                         $client->send(json_encode(array('message'=>$input->message,"to_user_id"=>$input->to_user_id,"user_id"=>$input->user_id)));
                     }
                 }

             }


         }

      //  $numRecv = count($this->clients) - 1;


    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        ChatUserManagement::where("resource_id",$conn->resourceId)->delete();
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

}