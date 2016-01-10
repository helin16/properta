<?php namespace App\Modules\Message\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\User\Models\User;
use App\Modules\Message\Models\Media;

class Message extends BaseModel
{
    public static function getAll($pageSize = null)
    {
        $query = self::orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        return $query->paginate($pageSize ?: self::$pageSize);
    }
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function media()
    {
        return Media::whereIn('id', json_decode($this->media_ids));
    }
}