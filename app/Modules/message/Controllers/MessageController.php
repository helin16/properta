<?php namespace App\Modules\Message\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;

class MessageController extends BaseController 
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct(){
//         $value = Session::get('currentUserId');
//         if(!$value){
//             Redirect::to('user')->send();
//         }

    }

	public function index()
	{

//         $value = Session::get('currentUser');
//         Redirect::to('user');

		return view("message::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		//return view('message::detail', ['message' => Message::find($id)]);
		return view('message::detail');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		return view('message::compose');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
}
