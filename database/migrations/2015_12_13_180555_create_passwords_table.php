<?php
namespace Database\Migrations;

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
            $table->string('user_id', $this->foreign_key_string_length)->unique();
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
