<?php

namespace nattaponra\chatkun;


interface ChatKunServiceInterface
{

    public function sendMessage($formUserID, $toUserID, $message);

}