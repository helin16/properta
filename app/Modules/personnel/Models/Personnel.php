<?php namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use App;

class Personnel extends Model {

	protected function checkUserAccess(){
        $currentUserID = Session::get('currentUser');
        return App::abort(403, 'Access denied');

        //return $currentUserID;
    }

}
