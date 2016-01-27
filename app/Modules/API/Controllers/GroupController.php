<?php namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\System\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GroupController extends APIController {
	protected $_entityName = \App\Modules\MoneyPool\Models\Group::class;
	/**
	 * 
	 * {@inheritDoc}
	 * @see \App\Modules\API\Controllers\APIController::update()
	 */
	public function update($id) {
		// validate
    // read more on validation at http://laravel.com/docs/validation
    $rules = array(
        'name'       => 'required'
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
    	return Response::make([
			    'message' => 'Validation Failed',
			    'errors' => $validator->errors()
			]);
    }
    
    $className = $this->_entityName;
    $entity = $className::find ( $id );
    $entity->name = Input::get('name');
    $entity->description = Input::get('description');
    $entity->save();
    return $entity->toJson();
	}
}