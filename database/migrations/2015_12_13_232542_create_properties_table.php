<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('address_id');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('properties');
    }
}
