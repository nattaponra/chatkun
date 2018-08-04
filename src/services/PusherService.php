<?php


namespace nattaponra\chatkun\services;



use nattaponra\chatkun\ChatKunMessage;
use Pusher\Pusher;
use Pusher\PusherException;

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
        try {
            $this->pusher = new Pusher($this->app_key, $this->secret_key, $this->app_id, $this->options);
        } catch (PusherException $e) {
        }
    }

    public function sendMessage(ChatKunMessage $chatKunMessage)
    {
        $data['message_type']    = $chatKunMessage->message_type;
        $data['message_content'] = $chatKunMessage->message_content;
        $data['sender_name']     = $chatKunMessage->user->name;
        $data['sender_id']       = $chatKunMessage->user->id;
        try {
            return $this->pusher->trigger($chatKunMessage->room_id . '-channel', "my-event", $data);
        } catch (PusherException $e) {

        }
    }
}