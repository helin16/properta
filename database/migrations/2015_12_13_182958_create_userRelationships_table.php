<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateUserRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('userRelationships', function (Blueprint $table) {
            $table->string('parent_user_id', $table->foreign_key_string_length);
            $table->string('user_id', $table->foreign_key_string_length);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('userRelationships');
    }
}
