<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('medias', function (Blueprint $table) {
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
        $this->schema->dropIfExists('medias');
    }
}
