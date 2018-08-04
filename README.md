# chatkun
## Install library with composer.
  Install Package with Composer
  You can use composer to install chatkun package follow below command.
```
composer require nattaponra/chatkun
```

## 1.Add Service Provider
```php
 'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
         .
         .
         .
         .
         nattaponra\chatkun\ChatKunServiceProvider::class,
        
 ```
## 2.Add trait in User model
Execute the vendor:publish command to create config file in your project:
```
php artisan vendor:publish --provider=ChatKunServiceProvider
```

## 3.Using
```php
    $user1 = User::find(1);
    $user2 = User::find(2);

    $room  = ChatKun::createRoom("Our Room");

    ChatKun::addMember($user1,$room);
    ChatKun::addMember($user2,$room);


    ChatKun::send($user1,$room,"message","hi!! user2");
    ChatKun::send($user2,$room,"message","hi!! user1");
    ChatKun::send($user1,$room,"image","http://pwtthemes.com/demo/hannari/wp-content/uploads/2013/03/unicorn-wallpaper.jpg");

     $results = ChatKun::history(1,10);

     foreach ($results as $result){
         
         if($result->message_type == "image"){
             echo "User:".$result->user_id." Say that <img src='$result->message_content'><br>";
             
         }else{
             echo "User:".$result->user_id." Say that ".$result->message_content."<br>";
         }
     }
```