<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Address;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Rental\Models\PropertyDetail;
use Illuminate\Support\Facades\Session;
use App\Modules\Rental\Models\RentalUser;
use App\Modules\User\Models\User;
use App\Modules\Rental\Models\Rental;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        Personnel::checkUserAccess();
        return view('rental::property.list', ['data' => Property::getAll(
            isset($_REQUEST['address_id']) ? $_REQUEST['address_id'] : null
        )]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $property = [
            'id' => $request->all()['property_id'],
            'description' => $request->all()['property_description'],
        ];

        $property_details = [
            'id' => $request->all()['property_detail_id'],
            'type' => $request->all()['property_details_type'],
            'carParks' => ($tmp = trim($request->all()['property_details_carParks'])) === '' ? null : intval($tmp),
            'bedrooms' => ($tmp = trim($request->all()['property_details_bedrooms'])) === '' ? null : intval($tmp),
            'bathrooms' => ($tmp = trim($request->all()['property_details_bathrooms'])) === '' ? null : intval($tmp),
            'options' => self::stripPropertyDetailOptions($request),
        ];
        $address = [
            'id' => $request->all()['address_id'],
            'street' => $request->all()['address_street'],
            'suburb' => $request->all()['address_suburb'],
            'state' => $request->all()['address_state'],
            'country' => $request->all()['address_country'],
            'postcode' => $request->all()['address_postcode'],
        ];
        $address = Address::store($address['street'], $address['suburb'], $address['state'], $address['country'], $address['postcode'], $address['id']);
        $property = Property::store($property['description'], $address, $property['id']);
        PropertyDetail::store($property, $property_details['type'], $property_details['carParks'], $property_details['bedrooms'], $property_details['bathrooms'], $property_details['options'], $property_details['id']);
        return Redirect::route('property.index');
    }
    public static function stripPropertyDetailOptions(Request $request)
    {
        $result = [];
        $regex = '/^property_details_option_/';
        $options = array_intersect_key($request->all(), array_flip(preg_grep($regex, array_keys($request->all()))));
        foreach($options as $key => $value)
            if(preg_match($regex, $key))
                $result[] = [preg_replace($regex, '', $key) => $value];
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null){
        return view('rental::property.detail', ['property' => Property::find($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        Property::destroy($id);
        return Redirect::to('property');
    }

    private function checkPermission($id){
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            abort(403);

        $ids = [];
        foreach(RentalUser::where('user_id', 1)->get() as $rental_user)
            if(($rental = Rental::find($rental_user->rental_id)) instanceof Rental)
                $ids[] = $rental->property_id;
        $ids = array_unique($ids);

        if(($property = Property::find($id)) instanceof Property && !in_array($property->id, $ids))
            abort(403);
    }
}
