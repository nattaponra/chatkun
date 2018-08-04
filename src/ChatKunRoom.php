<?php


namespace nattaponra\chatkun;



use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunRoom extends Model
{

    /** @var string  */
    const USER_TO_USER_ROOM = 'user_to_user';


    /** @var string  */
    const GROUP_ROOM = 'group';


    protected $fillable  = ["name","room_type"];

    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_rooms";
        parent::__construct($attributes);
    }


}