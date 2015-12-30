{!! Form::select('rental_id', (
        array_reduce($rentals->all(), function ($result, $item) {
                    $result[$item->id] = $item->inline();
                    return $result;
                }, array('0' => 'Select One Rental'))
), ((isset($rental) && $rental) ? $rental->id : null), (isset($options) ? $options : ['class' => 'form-control'])) !!}