<?php namespace App\Modules\Rental\Models;
setlocale(LC_MONETARY, 'en_AU.UTF-8');

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Message\Models\Media;
use Carbon\Carbon;
use NumberFormatter;
use App\Modules\Issue\Models\Issue;
use App\Modules\User\Models\User;
use Session;

class Rental extends BaseModel
{
    protected $fillable = ['dailyAmount', 'from', 'to', 'property_id', 'media_ids'];
    protected $dates = ['from', 'to'];
    public static function getAll($property_id = null, $pageSize = null)
    {
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            abort(403);

        $ids = [];
        foreach(RentalUser::where('user_id', 1)->get() as $rental_user)
            $ids[] = $rental_user->rental_id;
        $ids = array_unique($ids);

        $query = self::whereIn('id', $ids)->orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        if($property_id)
            $query->where('property_id', intval($property_id));
        return $query->paginate($pageSize ?: self::$pageSize);
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
        $media_ids = [];
        if(!is_array($media))
        $media = [$media];
        foreach($media as $single_media)
            if($single_media instanceof Media)
                $media_ids[] = $single_media->id;
        $dailyAmount = numfmt_parse(numfmt_create('en_AU', NumberFormatter::DECIMAL), $dailyAmount) ?: numfmt_parse(numfmt_create('en_AU', NumberFormatter::CURRENCY), $dailyAmount);
        return self::updateOrCreate(['id' => $id],
            ['dailyAmount' => $dailyAmount,
            'from' => empty($from) ? null : new Carbon($from),
            'to' =>  empty($to) ? null : new Carbon($to),
            'property_id' => $property->id,
            'media_ids' => json_encode($media_ids),
        ]);
    }
}