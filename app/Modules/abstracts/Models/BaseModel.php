<?php
namespace App\Modules\Abstracts\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * Get the creator
     */
    public function created_by()
    {
    	return $this->belongsTo(\App\Modules\System\Models\User::class, 'created_by');
    }
    /**
     * Get the updater
     */
    public function updated_by()
    {
    	return $this->belongsTo(\App\Modules\System\Models\User::class, 'updated_by');
    }
}
