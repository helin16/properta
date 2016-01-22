<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreatePropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('property_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id');
            $table->string('type', $table->type_string_length);
            $table->unsignedTinyInteger('carParks')->nullable()->default(null);
            $table->unsignedTinyInteger('bedrooms')->nullable()->default(null);
            $table->unsignedTinyInteger('bathrooms')->nullable()->default(null);
            $table->json('options');

            $table->index('type');
            $table->index('bedrooms');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('property_details');
    }
}
