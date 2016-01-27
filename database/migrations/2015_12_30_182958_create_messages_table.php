<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateMessagesTable extends Migration
{
    protected $_tableName = 'messages';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('from_user_id');
        $table->unsignedInteger('to_user_id');
        $table->char('subject');
        $table->text('content');
        $table->text('media_ids');
        $table->index('subject');
        $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
    }
}