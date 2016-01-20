<?php namespace App\Modules\Message\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Message\Models\Message;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Modules\User\Models\User;
use Validator;
use Session;


class MessageController extends BaseController 
{
	public function index()
    {
        return view('message::message.list', ['data' => Message::getAll(
//            isset($_REQUEST['address_id']) ? $_REQUEST['address_id'] : null
        )]);
    }

    public function createMessage(){
        $currentUserId = Session::get('currentUserId');
        $data = User::getRelevantUsers($currentUserId);


        return view('message::message.create', ['data' => $data]);
    }

    public function postMessage(){

        $data = Input::all();

        $rules = array(
            'subject' => 'required',
            'content' => 'required'
        );
        var_dump($data);
        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            // If validation falis redirect back to login.
            return Redirect::back()->withErrors($validator);
        }
        $data['from_user_id'] = Session::get('currentUserId');
        Message::insertMessage($data);
        Session::flash('success', 'Your message has been sent');
        return Redirect::back()->withErrors('Your profile has been saved!');

    }


    public function detail(){

        $currentUserId = Session::get('currentUserId');

        $data = Message::find($_REQUEST['id']);
        return view('message::message.detail', ['data' => $data]);
    }


}
