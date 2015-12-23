<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;
use Carbon\Carbon;

class Rental extends BaseModel
{
    protected $fillable = ['dailyAmount', 'from', 'to', 'property_id', 'address_id'];
    protected $dates = ['from', 'to'];
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        // property
        $array['property'] = Property::find($array['property_id']) ? Property::find($array['property_id'])->toArray() : [];
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
    public static function store($dailyAmount, $from, $to, Property $property = null, $id = null)
    {
        return self::updateOrCreate(['id' => $id], ['dailyAmount' => $dailyAmount, 'from' => new Carbon($from), 'to' => new Carbon($to), 'property_id' => $property->id]);
    }
}