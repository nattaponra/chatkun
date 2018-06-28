<?php


namespace nattaponra\chatkun\services;


use App\User;

interface ChatKunServiceInterface
{
   public function sendMessage(User $form,$to,$message);
}