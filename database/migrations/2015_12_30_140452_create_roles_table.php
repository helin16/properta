<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateRolesTable extends Migration
{
    protected $_tableName = 'roles';
    protected function _extraColumns(Blueprint $table) {
    	$table->char('name', 50);
    	$table->index(['name'], 'name');
    }
}

