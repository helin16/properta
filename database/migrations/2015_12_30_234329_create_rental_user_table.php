<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateRentalUserTable  extends Migration
{
    protected $_tableName = 'rental_user';
    protected $_hasId = false;
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('user_id');
        $table->unsignedInteger('role_id');
        $table->unsignedInteger('rental_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('rental_id')->references('id')->on('rentals')->onDelete('cascade');
    }
}