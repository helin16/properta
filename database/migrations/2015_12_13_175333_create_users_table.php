<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', $table->email_string_length)->unique();
            $table->string('username', 25);
            $table->string('brand_id', $table->foreign_key_string_length);
            $table->string('address_id', $table->foreign_key_string_length);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('users');
    }
}
