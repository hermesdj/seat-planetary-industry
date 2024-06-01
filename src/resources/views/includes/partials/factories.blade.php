<table class="table table-sm table-condensed table-striped table-hover" id="factoriesTable">
    <thead>
    <tr>
        <th>{{ trans('seat-pi::common.factory.headers.factory') }}</th>
        <th>{{ trans('seat-pi::common.factory.headers.quantity') }}</th>
        <th>{{ trans('seat-pi::common.factory.headers.tier') }}</th>
        <th>{{ trans('seat-pi::common.factory.headers.consumes') }}</th>
        <th>{{ trans('seat-pi::common.factory.headers.produces') }}</th>
        <th>{{ trans('seat-pi::common.cycle.header') }}</th>
        <th>{{ trans('seat-pi::common.cycle.last_cycle_start') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($factories as $factory)
        <tr>
            <td>
                @include('web::partials.type', [
                    'type_id' => $factory->schematic->type_id,
                    'type_name' => $factory->schematic->invType->typeName
                ])
            </td>
            <td>{{$factory->nbFactories}}</td>
            <td>
                {{$factory->schematic->tier->tier_id}}
            </td>
            <td>
                @foreach($factory->schematic->inputs as $input)
                    {{$factory->nbFactories * (3600 / $factory->schematic->cycle_time) * $input->quantity_consumed}}
                    &nbsp;
                    @include('web::partials.type', [
                        'type_id' => $input->invType->typeID,
                        'type_name' => $input->invType->typeName
                    ])
                    <br/>
                @endforeach
            </td>
            <td>{{$factory->nbFactories * (3600 / $factory->schematic->cycle_time) * $factory->schematic->tier->quantity_produced}}</td>
            <td>{{trans('seat-pi::common.cycle.time', ['time' => $factory->schematic->cycle_time])}}</td>
            <td>
                {{$factory->maxLastCycleStart}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

