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

}