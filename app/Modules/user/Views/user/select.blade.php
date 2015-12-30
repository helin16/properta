{!! Form::select('user_id', (
        array_reduce($users->all(), function ($result, $item) {
                    $result[$item->id] = $item->inline();
                    return $result;
                }, array('0' => 'Select One User'))
), ((isset($user) && $user) ? $user->id : null), (isset($options) ? $options : ['class' => 'form-control'])) !!}