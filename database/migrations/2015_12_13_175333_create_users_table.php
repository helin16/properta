<?php
use Database\Migrations\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', $this->email_string_length)->unique();
            $table->string('username', 25);
            $table->string('brand_id', $this->foreign_key_string_length);
            $table->string('address_id', $this->foreign_key_string_length);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
