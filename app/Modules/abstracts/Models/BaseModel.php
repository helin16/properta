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
    public static $pageSize = 5;
    public static function getAll()
    {
        $class = get_called_class();
        $data = $class::orderBy('id', 'desc')->paginate(self::$pageSize);
        return $data;
    }

    public static function getById($id)
    {
        $class = get_called_class();
        return $class::find($id) ? $class::find($id) : null;
    }
}
