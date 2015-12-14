<?php
use App\Database\Migrations\Migration;
use App\Database\Migrations\Blueprint;

class CreateAdminAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('admin_accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rental_id');
            $table->unsignedInteger('role_id');
            $table->boolean('canManage');
            $table->boolean('canIssue');
            $table->boolean('canStatement');
            $table->boolean('canMessage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('admin_accesses');
    }
}
