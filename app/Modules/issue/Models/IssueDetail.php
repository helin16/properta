<?php namespace App\Modules\Issue\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;

class IssueDetail extends BaseModel
{
    protected $fillable = ['issue_id', 'content', 'type', '3rdParty', 'priority', 'media_ids'];
    public function media()
    {
        return Media::whereIn('id', json_decode($this->media_ids));
    }
    public static function store(Issue $issue, $content = '', $type = '', $thirdParty = '', $priority = 0, array $media = [], $id = null)
    {
        $media_ids = [];
        if(!is_array($media))
            $media = [$media];
        foreach($media as $single_media)
            if($single_media instanceof Media)
                $media_ids[] = $single_media->id;

//        var_dump(json_encode($media_ids));
//        die;

        return self::updateOrCreate(
            ['id' => $id],
            ['issue_id' => $issue->id,
                'content' => $content,
                'type' => $type,
                '3rdParty' => $thirdParty,
                'priority' => $priority,
                'media_ids' => json_encode($media_ids),
            ]
        );
    }
}