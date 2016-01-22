<?php namespace App\Modules\Rental\Controllers;

use App\Modules\Abstracts\Controllers\BaseController;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Modules\User\Models\User;
use App\Modules\Rental\Models\RentalUser;
use App\Modules\User\Models\Role;

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
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            return Redirect::to('user')->send();

        if(!($role = Role::where('name', Session::get('currentUserRole'))->first()) instanceof Role)
            abort(403);

        $property = Property::findOrFail($request->all()['property_id']);
        $rental = [
            'id' => $request->all()['rental_id'],
            'dailyAmount' => $request->all()['rental_dailyAmount'],
            'from' => $request->all()['rental_from'],
            'to' => $request->all()['rental_to'],
            'media' => self::stripMedia($request),
        ];
        $rental = Rental::store($rental['dailyAmount'], $rental['from'], $rental['to'], $property, $rental['media'], $rental['id']);

        RentalUser::store($user, $rental, $role);

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
        self::checkPermission($id);
        return view('rental::rental.detail', ['rental' => Rental::find($id), 'properties' => Property::getAll(null, PHP_INT_MAX, true)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        self::checkPermission($id);
        Rental::destroy($id);
        return Redirect::to('rental');
    }
    private function checkPermission($id)
    {
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            return Redirect::to('user')->send();

        $ids = [];
        foreach(RentalUser::where('user_id', 1)->get() as $rental_user)
            if(($rental = Rental::find($rental_user->rental_id)) instanceof Rental)
                $ids[] = $rental->id;
        $ids = array_unique($ids);

        if(($rental = Rental::find($id)) instanceof Rental && !in_array($rental->id, $ids))
            abort(403);
    }
}
