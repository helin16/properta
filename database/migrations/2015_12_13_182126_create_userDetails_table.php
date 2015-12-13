<?php
namespace Database\Migrations;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('userDetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', $this->foreign_key_string_length);
            $table->string('name', 50);
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
        $this->schema->dropIfExists('userDetails');
    }
}
