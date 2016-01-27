<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateIssueDetailsTable  extends Migration
{
    protected $_tableName = 'issue_details';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('issue_id');
        $table->text('content');
        $table->char('type', $table->type_string_length);
        $table->char('3rdParty');
        $table->unsignedTinyInteger('priority');
        $table->text('media_ids');
        $table->index('type');
        $table->index('priority');
        $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
    }
}