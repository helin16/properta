<?php namespace App\Modules\Message\Models;

use App\Modules\Abstracts\Models\BaseModel;

class Media extends BaseModel
{
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['data'] = base64_encode(file_get_contents($array['path']));
        return $array;
    }
}