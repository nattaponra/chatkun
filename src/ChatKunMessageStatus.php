<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessageStatus extends Model
{

    /**
     * @var array 
     */
    protected $fillable  = ["message_id","user_id","status"];

    /**
     * ChatKunMessage constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_message_statuses";
        parent::__construct($attributes);
    }


    public function message(){
        return $this->hasOne(ChatKunMessage::class,"id","message_id");
    }

}