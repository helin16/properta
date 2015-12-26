<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Address;
use Illuminate\Support\Facades\Redirect;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rental::property.list', ['data' => Property::getAll()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = Address::store($request->all()['address_street'], $request->all()['address_suburb'], $request->all()['address_state'], $request->all()['address_country'], $request->all()['address_postcode'], $request->all()['address_id']);
        Property::store($request->all()['property_description'], $address, $request->all()['property_id']);
        return Redirect::to('property');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        return view('rental::property.detail', ['property' => Property::getById($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Property::destroy($id);
        return Redirect::to('property');
    }
}
