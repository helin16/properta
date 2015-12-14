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
        $this->schema->create('user_relationships', function (Blueprint $table) {
            $table->unsignedInteger('parent_user_id');
            $table->unsignedInteger('user_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('user_relationships');
    }
}
