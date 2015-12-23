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
    public static function getAll()
    {
        $class = get_called_class();
        return $class::all()->toArray();
    }

    public static function getById($id)
    {
        $class = get_called_class();
        return $class::find($id) ? $class::find($id)->toArray() : [];
    }
}
