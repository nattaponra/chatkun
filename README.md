# chatkun
## Install library with composer.
  Install Package with Composer
  You can use composer to install chatkun package follow below command.
```
composer require nattaponra/chatkun
```
## Example
```php
      $user1    = User::find(1);
      $user2    = User::find(2);

      $user1->chat->sendMessage($user2, "Hi user2");
      $user2->chat->sendMessage($user1, "Hello user1");
```