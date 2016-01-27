<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateUsersTable extends Migration
{
    protected $_tableName = 'users';
	protected function _extraColumns(Blueprint $table) {
		$table->char('firstname', 100);
		$table->char('lastname', 100);
		$table->char('email', 100);
	}
}
