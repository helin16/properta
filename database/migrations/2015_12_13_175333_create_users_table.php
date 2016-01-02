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
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('role_id');
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
