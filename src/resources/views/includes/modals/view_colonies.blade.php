<table class="table table-sm table-condensed table-striped table-hover" style="min-width: 500px;">
    <thead>
    <tr>
        <th>{{trans_choice('web::seat.character', count($colonies))}}</th>
        <th>{{trans('web::seat.planet')}}</th>
        <th>{{trans('seat-pi::common.cycle.state')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($colonies as $colony)
        <tr>
            <td>
                @include('web::partials.character', ['character' => $colony->character])
            </td>
            <td>
                <a href="#modalViewAssignedPlanet-{{$colony->id}}" data-toggle="modal"
                   data-target="#modalViewAssignedPlanet-{{$colony->id}}">
                    @include('web::partials.type', ['type_id' => $colony->planet->type->typeID, 'type_name' => ucwords($colony->planet->name)])
                    &nbsp;
                    ({{ucwords($colony->planet_type)}})
                </a>
            </td>
            <td>
                @foreach($colony->extractors as $extractor)
                    @if($extractor->product->typeID == $resource->typeID)
                        @if(Carbon\Carbon::parse($extractor->pin->expiry_time)->gte(Carbon\Carbon::now()) )
                            {{trans('seat-pi::common.cycle.active')}}
                        @else
                            {{trans('seat-pi::common.cycle.not_active')}}
                        @endif
                    @endif
                @endforeach
                @foreach($colony->factories as $factory)
                    @if($factory->schematic->type_id == $resource->typeID)
                        @if(Carbon\Carbon::parse($factory->maxLastCycleStart)->addSeconds($factory->schematic->cycle_time)->gte(Carbon\Carbon::now()->subDays(7)))
                            {{trans('seat-pi::common.cycle.active')}}
                        @else
                            {{trans('seat-pi::common.cycle.not_active')}}
                        @endif
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
