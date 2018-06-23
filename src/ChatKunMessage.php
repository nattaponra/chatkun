<?php


namespace nattaponra\chatkun;
use Illuminate\Database\Eloquent\Model;

class ChatKunMessage extends Model
{
    protected $fillable = ["user_id","to_user_id"];
    protected $table    = "chatkun_messages";

}