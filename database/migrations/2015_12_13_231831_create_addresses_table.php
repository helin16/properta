<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street', 50);
            $table->string('suburb', 50);
            $table->string('state', 50);
            $table->string('country', 50);
            $table->unsignedSmallInteger('postcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('addresses');
    }
}
