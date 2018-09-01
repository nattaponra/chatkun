<?php

namespace nattaponra\chatkun\tests;

use App\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use PHPUnit\Framework\TestCase;


class ChatkunTest extends TestCase
{
    use InteractsWithDatabase;

    public function testCreateUser1(){

        $user1 = User::create([
            "name"=>"user1",
            "email"=>"user1@chatkun.com",
            "password"=>"11111111",

        ]);

//        $this->assertDatabaseHas("users",[
//            "email" => "user1@chatkun.com"
//        ]);
        return $user1;
    }

    public function testCreateUser2(){

        $user2 = User::create([
            "name"=>"user2",
            "email"=>"user2@chatkun.com",
            "password"=>"22222222",

        ]);

//        $this->assertDatabaseHas("users",[
//            "email" => "user2@chatkun.com"
//        ]);

        return $user2;
    }


    /**
     * @depends testCreateUser1
     * @depends testCreateUser2
     */
    public function testClearData($user1,$user2){
//        $user1->delete();
//        $user2->delete();
    }


}