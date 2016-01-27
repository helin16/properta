<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateUserDetailsTable extends Migration
{
    protected $_tableName = 'user_details';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('user_id');
        $table->char('contactNumber', 50);
        $table->char('emergencyContact');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    }
}