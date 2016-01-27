<?php
use App\Modules\Abstracts\Models\Migration;
use App\Modules\Abstracts\Models\Blueprint;
class CreateMediaTable  extends Migration
{
    protected $_tableName = 'media';
    protected function _extraColumns(Blueprint $table) {
        $table->char('mimeType');
        $table->char('name');
        $table->char('path');
    }
}