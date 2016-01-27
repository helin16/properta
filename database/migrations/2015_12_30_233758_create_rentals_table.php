<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateRentalsTable  extends Migration
{
    protected $_tableName = 'rentals';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('property_id');
        $table->double('dailyAmount', null, 4);
        $table->timestamp('from')->nullable()->default(null);
        $table->timestamp('to')->nullable()->default(null);
        $table->text('media_ids');
        $table->index('dailyAmount');
        $table->index('from');
        $table->index('to');
        $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
    }
}