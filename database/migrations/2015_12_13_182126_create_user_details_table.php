<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('contactNumber', 50);
            $table->string('emergencyContact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('user_details');
    }
}
