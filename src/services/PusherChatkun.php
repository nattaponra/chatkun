<?php


namespace nattaponra\chatkun\services;

use nattaponra\chatkun\ChatKunServiceInterface;
use Pusher\Pusher;

class PusherChatKun implements ChatKunServiceInterface
{
    private $app_id;
    private $auth_key;
    private $secret_key;
    private $cluster;
    private $pusher;
    private $event;

    public function __construct($auth_key, $app_id, $secret_key, $cluster = null, $event = "my-event")
    {
        $this->app_id     = $app_id;
        $this->auth_key   = $auth_key;
        $this->secret_key = $secret_key;
        $this->cluster    = $cluster;
        $this->event      = $event;

        $options = array(
            'encrypted' => true
        );

        if (!empty($cluster)) {
            $options['cluster'] = $cluster;
        }

        $this->pusher = new Pusher(
            $auth_key,
            $secret_key,
            $app_id,
            $options
        );
    }



    public function sendMessage($formUserID, $toUserID, $message, $option)
    {
        $data            = $option;
        $data['message'] = $message;
        $data['from']    = $formUserID;
        return $this->pusher->trigger($toUserID, $this->event, $data);
    }



}