<?php

namespace App\Database\Migrations;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    public $foreign_key_string_length = 25;
    public $email_string_length = 50;
    public $name_string_length = 25;
    public $description_string_length = 25;
    public $type_string_length = 50;
    public $status_string_length = 50;
    public $table_name_string_length = 100;
    public function nameAndDescription()
    {
        $this->string('name', $this->name_string_length);
        $this->string('description', $this->description_string_length);
    }
}
