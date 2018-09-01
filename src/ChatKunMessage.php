<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessage extends Model
{
    /**
     * @var array 
     */
    protected $fillable  = ["message_type","message_content","user_id","room_id"];

    /**
     * ChatKunMessage constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_messages";
        parent::__construct($attributes);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne("App\User","id","user_id");
    }


    /**
     * @return mixed
     */
    public function getMessage(){
        return $this->message_content;
    }


    public function messageStatus(){
        return $this->hasOne(ChatKunMessageStatus::class,"message_id","id" );
    }

}