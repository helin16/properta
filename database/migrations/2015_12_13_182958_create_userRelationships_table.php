<?php
namespace Database\Migrations;

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
        $this->schema->dropIfExists('userRelationships');
    }
}
