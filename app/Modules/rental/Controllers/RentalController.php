<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Rental\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends BaseController 
{
	//
    public function __construct(){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//    	$items = Rental::all()->toArray();
//        $items = DB::table('rentals')->paginate(15)->toArray();
        $items = Rental::paginate(15)->toArray();

//        return $items;
    	return view('rental::rentals', compact('items'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	//
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	//
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	//
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	//
    }
}
