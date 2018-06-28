<?php


namespace nattaponra\chatkun\services;


use App\User;
use Pusher\Pusher;

class PusherService implements ChatKunServiceInterface
{
    private $app_id;
    private $app_key;
    private $secret_key;
    private $pusher;
    private $options;

    public function __construct()
    {

       $this->app_id     = config("chatkun.services.pusher.app_id");
       $this->app_key    = config("chatkun.services.pusher.key");
       $this->secret_key = config("chatkun.services.pusher.secret");
       $this->options    = config("chatkun.services.pusher.options");
       $this->pusher     = new Pusher($this->app_key, $this->secret_key, $this->app_id, $this->options);
    }

    public function sendMessage(User $user, $to, $message,$event="my")
    {
        $data['message']     = $message;
        $data['sender_id']   = $user->id;
        $data['sender_name'] = $user->name;

        return $this->pusher->trigger($to.'-channel', $event."-event", $data);
    }
}