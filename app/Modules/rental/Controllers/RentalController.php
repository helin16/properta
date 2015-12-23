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
        return view('rental::rental.list', ['rentals' => Rental::getAll()]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = Address::store($request->all()['address_street'], $request->all()['address_suburb'], $request->all()['address_state'], $request->all()['address_country'], $request->all()['address_postcode'], $request->all()['address_id']);
        $property = Property::store($request->all()['property_description'], $address, $request->all()['property_id']);
        Rental::store($request->all()['rental_dailyAmount'], $request->all()['rental_from'], $request->all()['rental_to'], $property, $request->all()['rental_id']);
        return $this->index();
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('rental::rental.detail', ['rental' => Rental::getById($id)]);
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
