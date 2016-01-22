{!! Form::select(((isset($saveItem) ? $saveItem : '') . 'user_id'), (
        array_reduce(is_array($users) ? $users : $users->all(), function ($result, $item) {
                    $result[$item->id] = $item->inline();
                    return $result;
                }, in_array(Session::get('currentUserRole'), ['agency admin', 'agent']) ? ['0' => 'Select One User'] : [])
), ((isset($user) && $user) ? $user->id : null), (isset($options) ? $options : ['class' => 'form-control'])) !!}