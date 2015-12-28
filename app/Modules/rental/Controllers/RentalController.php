<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Rental;
use App\Modules\Rental\Models\Address;
use Illuminate\Http\Request;

class RentalController extends BaseController 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rental::rental.list', ['data' => Rental::getAll()]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        die(var_dump($request->all()));
        Rental::store($request->all()['rental_dailyAmount'], $request->all()['rental_from'], $request->all()['rental_to'], Property::findOrFail($request->all()['property_id']), $request->all()['rental_id']);
        return $this->index();
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        return view('rental::rental.detail', ['rental' => Rental::getById($id), 'properties' => Property::getAll(false)]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rental::destroy($id);
        return $this->index();
    }
}
