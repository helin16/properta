<?php namespace App\Modules\Message\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\User\Models\User;
use App\Modules\Message\Models\Media;
use Session;

class Message extends BaseModel
{
    protected $table = 'messages';
    protected $fillable = ['subject' , 'content' , 'from_user_id' , 'to_user_id' ];

    public static function getAll($pageSize = null){
        $toUserId = Session::get('currentUserId');
        $query = self::where('to_user_id',$toUserId);
        //$query = self::orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        return $query->paginate($pageSize ?: self::$pageSize);
    }

    public function from_user(){
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to_user(){
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function media(){
        return Media::whereIn('id', json_decode($this->media_ids));
    }

    protected function insertMessage($data){
        Message::create(['subject' => $data['subject'] ,
                         'to_user_id' => $data['to_user_id'] ,
                         'content' => $data['content'],
                         'from_user_id' => $data['from_user_id'] ]);
    }



}