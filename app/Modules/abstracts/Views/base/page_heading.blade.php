<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>
            {{ substr(class_basename(Route::currentRouteAction()), 0,
            (strpos(class_basename(Route::currentRouteAction()), 'Controller') -0) )
            }}
            @if(isset($data))
                <span>{{ '(' . $data->total() . ')' }}</span>
            @endif
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Home</a>
            </li>
            <li class="active">
                <strong>
                    {{ substr(class_basename(Route::currentRouteAction()),
                        (strpos(class_basename(Route::currentRouteAction()), '@') + 1))
                    }}
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>