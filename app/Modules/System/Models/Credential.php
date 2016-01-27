<?php

namespace App\Modules\System\Models;

use App\Modules\Abstracts\Models\BaseModel;

class Credential extends BaseModel {
	const TYPE_NORMAL = 1;
	const TYPE_PASSWORD_RESET = 2;
	const TYPE_API_TOKEN = 3;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'credentials';
	public static function getCredentialTypes() {
		return [
    		self::TYPE_API_TOKEN, self::TYPE_NORMAL, self::TYPE_PASSWORD_RESET
    	];
	}
	public function user() {
		$this->belongsTo(User::class, 'user_id');
	}
}
