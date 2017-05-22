# ChatKun
Laravel package for make sample chat application with Ratchet WebSockets.

## Server Requirements
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension


# Installation and Setting

## 1. Install Package with Composer
You can use composer to install chatkun package follow below command.
```php
composer require nattaponra/chatkun
```

## 2. Installation authentication page
Use artisan command to create authentication page. If you already make authentication you can skip this step.
```php
php artisan make:auth
```
## 3. Register Service Provider
Before you can use chatkun package you must register service provider first!
```php
  Go to>config/app.php and append below command into this file.
  
      'providers' => [
                     .
                     .
                     .
                     .
              NattaponRa\chatkun\ChatKunServiceProvider::class,
        ],
 
```

## 4. Make Vender:Publish
Use artisan command to generate our resource such as view,controller,model and migration.
```php
 php artisan vendor:publish
    
```

## 5. Create database table with migration file.
Use artisan command to automaticaly create database tables from migration file.
```php
 php artisan migrate
    
```
## 6. Add Command path in array "commands" in Kernel.php 
Add command path for enable custome artisam command
```php
#  'App\Console\Kernel.php'
 
    protected $commands = [
        'App\Console\Commands\ChatKunWSServer'
    ];
```
   

## 7. Add Route 
Add our router for make chatting example page.
```php
#routes/web.php

Route::get('/chatkun',  'ChatKunController@index');
   
```
## 8. Server Setting
Please change below ip address to ip address of your server.
```javascript
 $.ajax({
                    method: "GET",
                    url: "http://192.168.1.10/chatkun/history/"+user_id,
                    data: { name: "John", location: "Boston" }
                })
```
## And
```javascript
      function connect() {
                    var socket;
                    var host = "ws://192.168.1.10:9090";
                    try {
                        var socket = new WebSocket(host);
                        socket.onopen = function () {
                            var inputData = {};
                            inputData["message"] = 'connect';
                            inputData["user_id"] = $("#user_id").val();
                            inputData["to_user_id"] = 'connect';
                            socket.send(JSON.stringify(inputData));
                        }
                        socket.onmessage = function (msg) {

                            var newMessage=JSON.parse(msg.data);
                            console.log(newMessage.message);
                            drawMessage(newMessage.message,'', 'right');
                        }
                        socket.onclose = function () {

                        }

                    } catch (exception) {

                    }

                    drawMessage=  function(message,time, side) {
                        $("#chat_area").append('<li class="'+side+' clearfix ">' +
                                '<span class="chat-img1 pull-' + side + '">' +
                                '<img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">' +
                                '</span>' +
                                '<div class="chat-body1 clearfix">' +
                                '<p>' + message + '</p>' +
                                '<div class="chat_time pull-'+side+'">'+time+'</div>' +
                                '</div>' +
                                '</li>');
                        $(".chat_area").animate({ scrollTop: 10000 }, "fast");
                    }

```


## 9. Run Web Socket
Open command line to run socket communication for support chatting.
```php
    php artisan chatkun:serve
```


