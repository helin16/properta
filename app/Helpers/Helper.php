<?php


namespace App\Helpers;

use Session;
use App\Modules\Message\Models\Message;

class Helper{

    static function getAllMessages(){

        $value = Session::get('currentUserId');
        $model = Message::where('to_user_id',$value);
        return $model;
    }
}

