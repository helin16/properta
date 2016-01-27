<?php
namespace App\Modules\Abstracts\Models;
use Illuminate\Support\Facades\DB;

class Migration extends \Illuminate\Database\Migrations\Migration
{
    protected $_tableName = '';
    protected $_hasId = true;
    protected $schema;
    protected function _extraColumns(Blueprint $table) {
        //
    }
    public function __construct()
    {
        $this->schema = DB::connection()->getSchemaBuilder();

        $this->schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->schema->create ( $this->_tableName, function (Blueprint $table) {
            if($this->_hasId)
                $table->increments('id');
            $this->_extraColumns($table);
            $table->basicEntityColumns ();
        } );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $this->schema->dropIfExists ( $this->_tableName );
    }
}