<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->nameAndDescription();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('roles');
    }
}
