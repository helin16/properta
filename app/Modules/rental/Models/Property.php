<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Rental\Models\Address;
use App\Modules\Rental\Models\Rental;

class Property extends BaseModel
{
    protected $fillable = ['description', 'address_id'];
//    /**
//     * Get the collection of items as a plain array.
//     *
//     * @return array
//     */
//    public function toArray()
//    {
//        $array = parent::toArray();
//        $array['address'] = Address::findOrFail($array['address_id'])->toArray();
//        unset($array['address_id']);
//        return $array;
//    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function rentals()
    {
//        var_dump($this->id);
//        $data = Rental::where('property_id', '=', 1)->get();
////        $data = Rental::all();
        $data = $this->hasMany(Rental::class);
        return $data;
    }

    public function rental()
    {
        $result = ['averageDailyAmount' => [], 'count' => 0];

        foreach($this->hasMany(Rental::class)->get() as $rental)
        {
            if(doubleval($rental->dailyAmount) > 0)
                $result['averageDailyAmount'][] = doubleval($rental->dailyAmount);
        }
        $result['count'] = sizeof($result['averageDailyAmount']);
        $result['averageDailyAmount'] = sizeof($result['averageDailyAmount']) > 0 ? array_sum($result['averageDailyAmount']) / sizeof($result['averageDailyAmount']) : 0;
        return $result;
    }

    /**
     * update or create new
     *
     * @param $description
     * @param null $id
     * @return static
     */
    public static function store($description, Address $address = null, $id = null)
    {
        return self::updateOrCreate(['id' => $id], ['description' => $description, 'address_id' => $address->id]);
    }
}