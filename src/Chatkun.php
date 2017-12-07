<?php

namespace nattaponra\chatkun;


class Chatkun
{

    private $service;

    public function __construct(iChatkun $chatkun)
    {
        $this->service = $chatkun;

    }

    public function sendMessage($formUserID, $toUserID, $message)
    {
        return $this->service->sendMessage($formUserID, $toUserID, $message);
    }


//    private $pusher;
//    private $userId;
//    private $event;
//
//    public function __construct($auth_key, $secret, $app_id, $cluster = null)
//    {
//        /** Set default value for testing. */
//        $this->userId = 'my-channel';
//        $this->event = 'my-event';
//
//        $options = array(
//            'encrypted' => true
//        );
//
//        if ($cluster != null) {
//            $options['cluster'] = $cluster;
//        }
//        $this->pusher = new Pusher(
//            $auth_key,
//            $secret,
//            $app_id,
//            $options
//        );
//    }
//
//    public function setUserId($userId)
//    {
//        $this->userId = $userId;
//    }
//
//    public function setEvent($event)
//    {
//        $this->event = $event;
//    }
//
//    public function sendMessageToUser($from_user_id, $to_user_id, $message, $optionData = array())
//    {
//        $data = array('message' => $message, 'from' => $from_user_id);
//        foreach ($optionData as $key => $value) {
//            $data[$key] = $value;
//        }
//        return $this->pusher->trigger($to_user_id, $this->event, $data);
//    }
//
//    public function sendMessageToMultiUser($to_users_id, $message)
//    {
//        foreach ($to_users_id as $user_id) {
//
//            $this->pusher->trigger($user_id, $this->event, array('message' => $message));
//
//        }
//    }

}