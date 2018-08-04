<?php
namespace nattaponra\chatkun\Facades;
use App\User;
use Illuminate\Support\Facades\Facade;
use nattaponra\chatkun\ChatKunRoom;


/**
 * @method static \nattaponra\chatkun\ChatKunRoom createRoom(string $name)
 * @method static \nattaponra\chatkun\ChatKunRoomMember addMember(User $user,ChatKunRoom $chatKunRoom))
 * @method static \nattaponra\chatkun\ChatKunMessage send(User $user,ChatKunRoom $chatKunRoom ,string $messageType, string $messageContent)
 * @method static \nattaponra\chatkun\ChatKunRoom findRoom(int $roomId)
 * @method static \nattaponra\chatkun\ChatKunRoom history(int $roomId)
 */



class ChatKun extends Facade
{



    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chatkun';
    }
}