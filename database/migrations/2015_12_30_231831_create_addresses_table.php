<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateAddressesTable extends Migration
{
    protected $_tableName = 'addresses';
    protected function _extraColumns(Blueprint $table) {
        $table->char('street', 50);
        $table->char('suburb', 50);
        $table->char('state', 50);
        $table->char('country', 50);
        $table->unsignedSmallInteger('postcode');
        $table->index('suburb');
        $table->index('postcode');
    }
}