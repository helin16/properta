<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('permissions', function (Blueprint $table) {
            $table->unsignedInteger('action_id', $table->foreign_key_string_length);
            $table->unsignedInteger('role_id', $table->foreign_key_string_length);
            $table->boolean('permitted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists("permissions");
    }
}
