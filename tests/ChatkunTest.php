<?php
require_once __DIR__ . '/../app/autoload.php';

use nattaponra\chatkun\Chatkun;
use nattaponra\chatkun\services\PusherChatkun;
use PHPUnit\Framework\TestCase;


class chatkunTest extends TestCase
{


    public function testSend()
    {
        $chatkun = new Chatkun(new PusherChatkun("71baa59665e9ba7ac6e9", "344751", "8efbc5d481a62566ace8", "ap1"));
        $result = $chatkun->sendMessage("1", "2", "Hello");
        print_r($result);
    }

}