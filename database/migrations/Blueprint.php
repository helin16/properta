<?php

namespace Database\Migrations;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    public $foreign_key_string_length = 25;
    public $email_string_length = 50;
    public $name_string_length = 25;
    public $description_string_length = 25;
    public function nameAndDescription()
    {
        $this->string('name', $this->name_string_length);
        $this->string('description', $this->description_string_length);
    }
}
