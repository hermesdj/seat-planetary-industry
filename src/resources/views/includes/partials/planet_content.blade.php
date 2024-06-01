<table class="table table-sm table-condensed table-striped table-hover" id="contentTable">
    <thead>
    <tr>
        <th>{{ trans('web::seat.product') }}</th>
        <th>{{ trans('seat-pi::common.planet.headers.content') }}</th>
    </tr>
    </thead>
    <tbody>
    @php
        $contents = $colony->contents->groupBy(function($item) {
            return $item->product->typeID;
        })->all();
    @endphp
    @foreach($contents as $typeID => $content)
        @if(!$content->isEmpty())
            <tr>
                <td>
                    @include('web::partials.type', ['type_id' => $typeID, 'type_name' => ucwords($content->get(0)->product->typeName)])
                </td>
                <td>{{number_format($content->sum('amount'))}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
