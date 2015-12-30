<?php namespace App\Modules\Issue\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Issue\Models\Issue;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use App\Modules\Rental\Models\Rental;
use Illuminate\Support\Facades\Redirect;

class IssueController extends BaseController 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issue::issue.list', ['data' => Issue::getAll(
            isset($_REQUEST['rental_id']) ? $_REQUEST['rental_id'] : null,
            isset($_REQUEST['requester_user_id']) ? $_REQUEST['requester_user_id'] : null
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
//        var_dump($request->all());
//        var_dump(array_intersect_key($request->all(), array_flip(preg_grep('/^property_details_option_/', array_keys($request->all())))));
        $address = [
            'id' => $request->all()['address_id'],
            'street' => $request->all()['address_street'],
            'suburb' => $request->all()['address_suburb'],
            'state' => $request->all()['address_state'],
            'country' => $request->all()['address_country'],
            'postcode' => $request->all()['address_postcode'],
        ];
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
        $address = Address::store($address['street'], $address['suburb'], $address['state'], $address['country'], $address['postcode'], $address['id']);
        $property = Property::store($property['description'], $address, $property['id']);
        PropertyDetail::store($property, $property_details['type'], $property_details['carParks'], $property_details['bedrooms'], $property_details['bathrooms'], $property_details['options'], $property_details['id']);
        return Redirect::to('property');
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
    public function show($id = 0)
    {
        return view('issue::issue.detail', ['issue' => Issue::find($id), 'users' => User::getAll(PHP_INT_MAX), 'rentals' => Rental::getAll(false)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Issue::destroy($id);
        return Redirect::to('issue');
    }
}
