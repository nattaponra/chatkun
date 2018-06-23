<?php


namespace nattaponra\chatkun;


use nattaponra\chatkun\services\PusherService;

class ChatKunFactory
{
    public  function getChatService($serviceName)
    {

        if ($serviceName == "pusher") {
            return new PusherService();

        } else {
            return null;
        }
    }
}