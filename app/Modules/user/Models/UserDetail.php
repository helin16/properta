<?php namespace App\Modules\User\Models;

use App\Modules\Abstracts\Models\BaseModel;

class UserDetail extends BaseModel
{
	public function fullName()
	{
		return (trim($this->firstName) === '' ? '' : ($this->firstName) . ' ') . $this->lastName;
	}
}