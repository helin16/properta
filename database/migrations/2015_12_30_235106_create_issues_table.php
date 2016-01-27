<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateIssuesTable extends Migration
{
    protected $_tableName = 'issues';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('requester_user_id');
        $table->unsignedInteger('rental_id');
        $table->char('status', $table->status_string_length);
        $table->index('status');
        $table->foreign('requester_user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('rental_id')->references('id')->on('rentals')->onDelete('cascade');
    }
}