<?php
use Database\Migrations\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userRelationships', function (Blueprint $table) {
            $table->string('parent_user_id', $this->foreign_key_string_length);
            $table->string('user_id', $this->foreign_key_string_length);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userRelationships');
    }
}
