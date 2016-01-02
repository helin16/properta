<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RentalController extends BaseController 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rental::rental.list', ['data' => Rental::getAll(
            isset($_REQUEST['property_id']) ? $_REQUEST['property_id'] : null
        )]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $property = Property::findOrFail($request->all()['property_id']);
        $rental = [
            'id' => $request->all()['rental_id'],
            'dailyAmount' => $request->all()['rental_dailyAmount'],
            'from' => $request->all()['rental_from'],
            'to' => $request->all()['rental_to'],
            'media' => self::stripMedia($request),
        ];
        Rental::store($rental['dailyAmount'], $rental['from'], $rental['to'], $property, $rental['media'], $rental['id']);
        return Redirect::route('rental.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        return view('rental::rental.detail', ['rental' => Rental::find($id), 'properties' => Property::getAll(null, PHP_INT_MAX)]);
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
        return Redirect::to('rental');
    }
}
