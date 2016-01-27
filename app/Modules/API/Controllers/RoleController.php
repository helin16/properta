<?php namespace App\Modules\API\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\System\Models\User;

class RoleController extends APIController {
	protected $_entityName = \App\Modules\System\Models\Role::class;
}