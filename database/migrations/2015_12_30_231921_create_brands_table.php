<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateBrandsTable   extends Migration
{
    protected $_tableName = 'brands';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('address_id');
        $table->text('settings');
        $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
    }
}