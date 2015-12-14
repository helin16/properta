<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requester_user_id');
            $table->unsignedInteger('rental_id');
            $table->string('status', $table->status_string_length);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('issues');
    }
}
