<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreatePropertiesTable    extends Migration
{
    protected $_tableName = 'properties';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('address_id');
        $table->text('description');
        $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
    }
}