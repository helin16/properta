<?php namespace App\Modules\Issue\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;

class IssueDetail extends BaseModel
{
    public function media()
    {
        return Media::whereIn('id', json_decode($this->media_ids));
    }
}