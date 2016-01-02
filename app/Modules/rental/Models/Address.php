<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;

class Address extends BaseModel
{
    protected $fillable = ['street', 'suburb', 'state', 'country', 'postcode'];

    /**
     * @param string $street
     * @param string $suburb
     * @param string $state
     * @param string $country
     * @param int $postcode
     * @param null|int $id
     * @return static
     */
    public static function store($street, $suburb, $state, $country, $postcode, $id = null)
    {
        return self::updateOrCreate(['id' => $id], compact('street', 'suburb', 'state', 'country', 'postcode'));
    }
    public function inline()
    {
        $result = '';
        foreach([$this->street, $this->suburb, $this->state, $this->country, $this->postcode] as $index => $string)
        {
            $string = trim($string);
            if($index !== 0 && $string !== '')
                $result .= ', ';
            $result .= $string;
        }
        return $result;
    }
}