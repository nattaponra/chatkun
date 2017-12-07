<?php
/**
 * Created by PhpStorm.
 * User: nattaponrakthong
 * Date: 12/7/2017 AD
 * Time: 10:44 PM
 */

namespace nattaponra\chatkun;


interface iChatkun
{
    public function authen();
    public function authenType();
    public function sendMessage($formUserID, $toUserID, $message);

}