{!! Form::select('property_id', (
        array_reduce($properties->all(), function ($result, $item) {
                    $result[$item->id] = $item->address->inline();
                    return $result;
                }, array('0' => 'Select One Property'))
), ((isset($property) && $property) ? $property->id : null), (isset($options) ? $options : [])) !!}