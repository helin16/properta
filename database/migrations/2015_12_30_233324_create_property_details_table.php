<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreatePropertyDetailsTable extends Migration
{
    protected $_tableName = 'property_details';
    protected function _extraColumns(Blueprint $table) {
        $table->unsignedInteger('property_id');
        $table->char('type', $table->type_string_length);
        $table->unsignedTinyInteger('carParks')->nullable()->default(null);
        $table->unsignedTinyInteger('bedrooms')->nullable()->default(null);
        $table->unsignedTinyInteger('bathrooms')->nullable()->default(null);
        $table->text('options');
        $table->index('type');
        $table->index('bedrooms');
        $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
    }
}