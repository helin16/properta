<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;

abstract class BaseModel extends Model
{
    public function performInsert(Builder $query, array $options = [])
    {
        $this->attributes['active'] = 1;
        return parent::performInsert($query, $options);
    }
    public static function blueprint(Blueprint &$table)
    {
        $table->boolean('active');
    }
}
