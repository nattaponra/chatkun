<?php


namespace nattaponra\chatkun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatKunRoom extends Model
{
    protected $fillable  = ["name"];

    public function __construct(array $attributes = [])
    {
        $this->table = "chatkun_rooms";
        parent::__construct($attributes);
    }


}