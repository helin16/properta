<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateIssueDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('issueDetails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('issue_id');
            $table->text('content');
            $table->string('3rdParty');
            $table->unsignedTinyInteger('priority');
            $table->json('media_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('issueDetails');
    }
}
