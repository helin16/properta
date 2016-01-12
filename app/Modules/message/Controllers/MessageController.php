<?php namespace App\Modules\Message\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use Session;
use App\Modules\Personnel\Models\Personnel;
use Illuminate\Support\Facades\Redirect;

class MessageController extends BaseController 
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct(){
        $value = Session::get('currentUserId');
        if(!$value){
            Redirect::to('user')->send();
        }

    }

	public function listall()
	{

        $value = Session::get('currentUser');
        Redirect::to('user');
        //Personnel::checkUserAccess();

		return view("message::list");
	}

	/**
	 * Show the form for compose the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function create($id)
	{
		//
		return view('message::create');
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function view()
	{
		//
		return view('message::view');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function delete()
	{
		//
		return view('message::delete');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reply($id)
	{
		//
		//return view('message::detail', ['message' => Message::find($id)]);
		return view('message::reply');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function forward($id)
	{
		//
		return view('message::forward');
	}

	
}
