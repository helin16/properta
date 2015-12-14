<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mimeType');
            $table->string('name');
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('media');
    }
}
