<?php


namespace nattaponra\chatkun\services;


interface ChatKunServiceInterface
{
   public function sendMessage($form,$to,$message);
}