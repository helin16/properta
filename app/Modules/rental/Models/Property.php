<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;

class Property extends BaseModel
{
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
}