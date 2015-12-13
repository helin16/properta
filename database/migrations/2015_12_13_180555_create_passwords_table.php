<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('passwords', function (Blueprint $table) {
            $table->string('user_id', $table->foreign_key_string_length)->unique();
            $table->primary('user_id');
            $table->string('password', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('passwords');
    }
}
