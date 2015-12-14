<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateIssueProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('issue_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('issue_id');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('issue_progress');
    }
}
