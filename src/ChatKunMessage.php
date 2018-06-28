<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessage extends Model
{
    protected $fillable             = ["user_id","to_user_id"];
    protected $table                = "chatkun_messages";
    private   $chatKunSubMessage;
    protected $appends = ["SenderName"];

    public function addSubMessage(ChatKunSubMessage $chatKunSubMessage){
        $this->chatKunSubMessage = $chatKunSubMessage;
    }

    public function getSubMessage(){
        return $this->chatKunSubMessage;
    }

    public function subMessage(){
        return $this->hasOne(ChatKunSubMessage::class,"messages_id","id");
    }

    public function senderUser(){
        return $this->hasOne("App\User","id","user_id");
    }

    public function getSenderNameAttribute(){
        if($this->senderUser){
            return  $this->senderUser->name;
        }
    }



}