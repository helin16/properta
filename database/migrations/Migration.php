<?php

namespace Database\Migrations;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Support\Facades\DB;

class Migration extends BaseMigration
{
    protected $schema;

    public function __construct()
    {
        $this->schema = DB::connection()->getSchemaBuilder();

        $this->schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
    }
}
