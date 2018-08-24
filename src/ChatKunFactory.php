<?php


namespace nattaponra\chatkun;


use nattaponra\chatkun\services\PusherService;

class ChatKunFactory
{
    /**
     * @param $serviceName
     * @return PusherService|null
     */
    public  function getChatService($serviceName)
    {

        if ($serviceName == "pusher") {
            return new PusherService();

        } else {
            return null;
        }
    }
}