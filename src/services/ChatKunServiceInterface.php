<?php


namespace nattaponra\chatkun\services;

use nattaponra\chatkun\ChatKunMessage;

interface ChatKunServiceInterface
{
   public function sendMessage(ChatKunMessage $chatKunMessage);
}