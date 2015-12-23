<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;

class Property extends BaseModel
{
    protected $fillable = ['description', 'address_id'];
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['address'] = Address::findOrFail($array['address_id'])->toArray();
        unset($array['address_id']);
        return $array;
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