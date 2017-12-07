<?php


namespace nattaponra\chatkun\services;

use nattaponra\chatkun\iChatkun;
use Pusher\Pusher;

class PusherChatkun implements iChatkun
{
    private $app_id;
    private $auth_key;
    private $secret_key;
    private $cluster;
    private $pusher;
    public function __construct($auth_key, $app_id, $secret_key, $cluster = null)
    {

        $this->app_id     = $app_id;
        $this->auth_key   = $auth_key;
        $this->secret_key = $secret_key;
        $this->cluster    = $cluster;

        $options = array(
            'encrypted' => true
        );

        if ($cluster != null) {
            $options['cluster'] = $cluster;
        }
        $this->pusher = new Pusher(
            $auth_key,
            $secret_key,
            $app_id,
            $options
        );
    }

    public function authen()
    {
        return ["auth_key" => $this->auth_key, "app_id" => $this->app_id, "secret_key" => $this->secret_key];
    }

    public function authenType()
    {
        return "app_id";
    }

    public function sendMessage($formUserID, $toUserID, $message)
    {
        $data = array('message' => $message, 'from' => $formUserID);

        return $this->pusher->trigger($toUserID, "my-event", $data);
    }
}