<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreatePropertyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('property_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id');
            $table->string('type', $table->type_string_length);
            $table->text('content');
            $table->json('comments');

            $table->index('type');
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
        $this->schema->dropIfExists('property_logs');
    }
}
