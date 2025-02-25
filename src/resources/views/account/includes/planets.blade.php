<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::common.menu.planets')}}</h3>
    </div>
    <div class="card-body">
        <table class="table datatable table-sm table-condensed table-striped table-hover">
            <thead>
            <tr>
                <th>{{trans_choice('web::seat.character', 2)}}</th>
                <th>{{trans('web::seat.planet')}}</th>
                <th>{{ trans('seat-pi::common.planet.headers.assignedTo') }}</th>
                <th>{{ trans('seat-pi::common.planet.headers.content') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($planets as $colony)
                <tr>
                    <td>
                        @include('web::partials.character', ['character' => $colony->character])
                    </td>
                    <td>
                        @include('web::partials.type', ['type_id' => $colony->planet->type->typeID, 'type_name' => ucwords($colony->planet->name)])
                        &nbsp;
                        ({{ucwords($colony->planet_type)}})
                    </td>
                    <td>
                        @if($colony->assignedToCorp)
                            <small class="badge bg-purple" data-toggle="tooltip" data-placement="top"
                                   title="{{trans('seat-pi::common.planet.assignedToCorp', ['corp' => $colony->assignedToCorp->project->corporation->name, 'name' => $colony->assignedToCorp->project->name])}}">
                                <i class="fas fa-copyright"></i>
                                {{$colony->assignedToCorp->project->name}}
                            </small>
                        @elseif($colony->assignedTo)
                            <small class="badge bg-blue" data-toggle="tooltip" data-placement="top"
                                   title="{{trans('seat-pi::common.planet.assignedTo', ['name' => $colony->assignedTo->project->name])}}">
                                {{$colony->assignedTo->project->name}}
                            </small>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php
                            $contents = $colony->contents
                                ->sortBy('type.typeName')
                                ->sortBy(function($content) {
                                    return $content->type->pi_tier->tier_id . $content->type->typeName;
                                })
                                ->groupBy('product.typeID');
                        @endphp
                        @foreach($contents as $typeID => $content)
                            @if(!$content->isEmpty())
                                @include('web::partials.type', ['type_id' => $typeID, 'type_name' => ucwords($content->get(0)->product->typeName)])
                                <b>{{number_format($content->sum('amount'))}}</b>
                                <small>(P{{ $content->get(0)->type->pi_tier->tier_id }})</small>
                                <br/>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
