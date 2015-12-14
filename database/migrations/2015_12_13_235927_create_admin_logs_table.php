<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('admin_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tableName', $table->table_name_string_length);
            $table->unsignedInteger('tableId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('admin_logs');
    }
}
