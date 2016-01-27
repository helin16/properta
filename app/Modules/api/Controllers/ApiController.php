<?php

namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class APIController extends Controller {
	const DEFAULT_PAGE_SIZE = 30;
	protected $_pageSize = self::DEFAULT_PAGE_SIZE;
	protected $_entityName = '';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$className = $this->_entityName;
		$result = $className::where ( 'active', 1 )->paginate ( $this->_pageSize );
		return json_encode ( $result->toArray () );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$entity = new $this->_entityName ();
		return json_encode ( $entity->toArray () );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function show($id, $someId = null) {
		$className = $this->_entityName;
		$entity = $className::find ( $id );
		return $entity->toJson ();
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		//
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		//
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
		//
	}
}