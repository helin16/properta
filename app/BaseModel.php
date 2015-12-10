<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\System;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseModel extends Model
{
    public function performInsert(Builder $query, array $options = [])
    {
        $this->attributes['active'] = 1;
        return parent::performInsert($query, $options);
    }
}
