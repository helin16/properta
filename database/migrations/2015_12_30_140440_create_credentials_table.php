<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
use App\Modules\System\Models\Credential;
class CreateCredentialsTable extends Migration
{
    protected $_tableName = 'credentials';
    protected function _extraColumns(Blueprint $table) {
		$table->unsignedInteger('user_id');
		$table->char('username', 50);
		$table->char('password', 100);
		$table->enum('type', Credential::getCredentialTypes());
		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->index(['username'], 'username');
		$table->index(['password'], 'password');
		$table->index(['type'], 'type');
	}
}
