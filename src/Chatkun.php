<?php

namespace nattaponra\chatkun;


class ChatKun
{
    private $service;

    public function __construct(ChatKunServiceInterface $chatKunServiceInterface)
    {
        $this->service = $chatKunServiceInterface;

    }

    public function sendMessage($formUserID, $toUserID, $message, $option = [])
    {
        return $this->service->sendMessage($formUserID, $toUserID, $message, $option);
    }

}