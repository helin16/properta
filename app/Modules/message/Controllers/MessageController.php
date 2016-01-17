<?php namespace App\Modules\Message\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Message\Models\Message;

class MessageController extends BaseController 
{
	public function index()
    {
        return view('message::message.list', ['data' => Message::getAll(
//            isset($_REQUEST['address_id']) ? $_REQUEST['address_id'] : null
        )]);
    }
}
