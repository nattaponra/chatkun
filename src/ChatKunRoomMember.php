<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunRoomMember extends Model
{
    protected $fillable  = ["room_id","user_id","role"];

    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_room_members";
        parent::__construct($attributes);
    }

    public function room(){
        return $this->hasOne(ChatKunRoom::class,"id","room_id");
    }

}