<?php

namespace App\Modules\MoneyPool\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Abstracts\Models\BaseModel;

class Transaction extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction';
    public function pool()
    {
    	return $this->belongsTo(\App\Modules\MoneyPool\Models\MoneyPool::class, 'poolId');
    }
}
