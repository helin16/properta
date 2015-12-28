<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;
use App\Modules\Rental\Models\Property;
use App\Modules\Rental\Models\Address;
use Carbon\Carbon;
use NumberFormatter;

class Rental extends BaseModel
{
    protected $fillable = ['dailyAmount', 'from', 'to', 'property_id', 'media_ids'];
    protected $dates = ['from', 'to'];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function media()
    {
        return Media::whereIn('id', json_decode($this->media_ids))->get()->all();
    }
    public static function store($dailyAmount, $from, $to, Property $property, $media = [], $id = null)
    {
//        var_dump($media);
        $fmt = new NumberFormatter( 'en_AU', NumberFormatter::CURRENCY );
        $media_ids = [];
        if(!is_array($media))
        $media = [$media];
        foreach($media as $single_media)
            if($single_media instanceof Media)
                $media_ids[] = $single_media->id;
        return self::updateOrCreate(['id' => $id], ['dailyAmount' => $fmt->parseCurrency($dailyAmount, $curr),
            'from' => empty($from) ? null : new Carbon($from),
            'to' =>  empty($to) ? null : new Carbon($to),
            'property_id' => $property->id,
            'media_ids' => json_encode($media_ids),
        ]);
    }
}