<?php namespace App\Modules\Rental\Models;
setlocale(LC_MONETARY, 'en_AU.UTF-8');

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;
use Carbon\Carbon;
use NumberFormatter;
use App\Modules\Issue\Models\Issue;

class Rental extends BaseModel
{
    protected $fillable = ['dailyAmount', 'from', 'to', 'property_id', 'media_ids'];
    protected $dates = ['from', 'to'];
    public static function getAll($property_id = null)
    {
        $query = self::orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        if($property_id)
            $query->where('property_id', intval($property_id));
        return $query->paginate(self::$pageSize);
    }
    public function inline()
    {
        return $this->property->address->inline() . ' (' . money_format('%.2n', $this->dailyAmount) . ')';
    }
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function media()
    {
        return Media::whereIn('id', json_decode($this->media_ids));
    }
    public static function store($dailyAmount, $from, $to, Property $property, $media = [], $id = null)
    {
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