<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::common.menu.factories')}}</h3>
    </div>
    <div class="card-body">
        <table class="table datatable table-sm table-condensed table-striped table-hover">
            <thead>
            <tr>
                <th>{{trans_choice('web::seat.character', 2)}}</th>
                <th>{{trans('web::seat.planet')}}</th>
                <th>{{ trans('web::seat.product') }}</th>
                <th>{{ trans('seat-pi::common.factory.headers.tier') }}</th>
                <th>{{ trans('seat-pi::common.factory.headers.consumes') }}</th>
                <th>{{ trans('seat-pi::common.factory.headers.produces') }}</th>
                <th>{{ trans('seat-pi::common.cycle.header') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($factories as $factory)
                <tr>
                    <td>
                        @include('web::partials.character', ['character' => $factory->character])
                    </td>
                    <td>
                        @include('web::partials.type', ['type_id' => $factory->colony->planet->type->typeID, 'type_name' => ucwords($factory->colony->planet->name)])
                        &nbsp;
                        ({{ucwords($factory->colony->planet_type)}})
                    </td>
                    <td>
                        {{$factory->nbFactories}}x&nbsp;
                        <img alt="Item image"
                             src="https://images.evetech.net/types/{{$factory->schematic->type_id}}/icon?size=32"/>

                        {{$factory->schematic->invType->typeName}}
                    </td>
                    <td>
                        {{$factory->schematic->tier->tier_id}}
                    </td>
                    <td>{{$factory->nbFactories * $factory->schematic->tier->quantity_consumed}}</td>
                    <td>{{$factory->nbFactories * $factory->schematic->tier->quantity_produced}}</td>
                    <td>{{trans('seat-pi::common.cycle.time', ['time' => $factory->schematic->cycle_time])}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
