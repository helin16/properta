<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateRoleUserTable extends Migration
{
    protected $_tableName = 'role_user';
	protected $_hasId = false;
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('user_id');
        $table->unsignedInteger('role_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    }
}