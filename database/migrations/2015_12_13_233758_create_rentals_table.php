<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id');
            $table->double('dailyAmount', null, 4);
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
            $table->json('media_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('rentals');
    }
}
