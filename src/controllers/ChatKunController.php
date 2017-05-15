<?php

namespace App\Http\Controllers;
use App\ChatMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ChatKunController extends Controller
{
    public function index(){




        $userData=  User::where("id","!=",Auth::user()->id)->get();

        $swID = rand(1, 87);
        $swChar = json_decode(file_get_contents('https://swapi.co/api/people/'.$swID.'/'));
        $userName = $swChar->name;

        $chatPort = \Request::input("p");
        $chatPort = $chatPort ?: 9090;

        return view('chatkun.index', compact("userData","chatPort", "userName"));

    }

    public function viewHistory($to_user_id){
        $user_id=Auth::user()->id;

//        $history_result=  DB::select("SELECT * FROM chat_messages
//                                            WHERE (chat_messages.user_id=$user_id AND chat_messages.to_user_id=$to_user_id)
//                                            OR    (chat_messages.user_id=$to_user_id AND chat_messages.to_user_id=$user_id)
//                                            ORDER BY chat_messages.id ASC");


        $history_result= ChatMessage::where("user_id",$user_id)->where("to_user_id",$to_user_id)->orwhere("user_id",$to_user_id)->where("to_user_id",$user_id)->get();


        return $history_result;

    }
}
