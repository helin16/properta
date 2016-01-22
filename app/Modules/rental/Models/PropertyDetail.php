<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;

class PropertyDetail extends BaseModel
{
    protected $fillable = ['property_id', 'type', 'carParks', 'bedrooms', 'bathrooms', 'options'];

    public function property(){
        return $this->belongsTo(Property::class);
    }

    public static function store(Property $property, $type = null, $carParks = null, $bedrooms = null, $bathrooms = null, array $options = [], $id = null)
    {
        return self::updateOrCreate(['id' => $id], ['property_id' => $property->id, 'type' => $type, 'carParks' => $carParks, 'bedrooms' => $bedrooms, 'bathrooms' => $bathrooms, 'options' => is_array($options) ? json_encode($options) : json_encode([])]);
    }
}