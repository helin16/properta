<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('address_id');
            $table->json('settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('brands');
    }
}
