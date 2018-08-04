<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessage extends Model
{
    protected $fillable  = ["message_type","message_content","user_id","room_id"];

    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_messages";
        parent::__construct($attributes);
    }


    public function user(){
        return $this->hasOne("App\User","id","user_id");
    }

}