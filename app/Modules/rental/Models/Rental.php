<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;

class Rental extends BaseModel
{
    protected $dates = ['from', 'to'];
//    protected $dateFormat = 'Y-m-d H:i:s';
	public function property()
    {
        return $this->belongsTo(Property::class);
    }
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        // property
        $array['property'] = Property::findOrFail($array['property_id'])->toArray();
        unset($array['property_id']);
        // media
        $array['media'] = [];
        if(is_array($media_ids = json_decode($array['media_ids'])))
            foreach($media_ids as $media_id)
                if(($media = Media::find($media_id)) instanceof Media)
                    $array['media'][] = $media->toArray();
        unset($array['media_ids']);

        return $array;
    }
}