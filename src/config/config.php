<?php
return [

     'default_service' => env('CHATKUN_SERVICE', 'pusher'),
     'services' => [
        'pusher' => [
            'app_id'  => env("PUSHER_APP_ID",""),
            'key'     => env("PUSHER_APP_KEY",""),
            'secret'  => env("PUSHER_APP_SECRET",""),
            'options' => [
                'cluster' => env("PUSHER_APP_CLUSTER","ap1"),
                'encrypted' => true
            ]
        ]
     ]
 ];
