<?php

namespace App\Modules\MoneyPool\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Abstracts\Models\BaseModel;

class MoneyPool extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'moneypools';
}
