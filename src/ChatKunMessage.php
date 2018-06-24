<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessage extends Model
{
    protected $fillable             = ["user_id","to_user_id"];
    protected $table                = "chatkun_messages";
    private   $chatKunSubMessages   = [];


    public function addSubMessages(ChatKunSubMessage $chatKunSubMessage){
        $this->chatKunSubMessages[] = $chatKunSubMessage;
    }

    public function getSubMessages(){
        return $this->chatKunSubMessages;
    }

    public function subMessages(){
        return $this->hasMany(ChatKunSubMessage::class,"messages_id","id");
    }


}