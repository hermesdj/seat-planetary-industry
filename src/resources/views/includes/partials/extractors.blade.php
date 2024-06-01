<table class="table table-sm table-condensed table-striped table-hover" id="extractorTable">
    <thead>
    <tr>
        <th>{{ trans('web::seat.product') }}</th>
        <th>{{ trans('web::seat.upgrade_level') }}</th>
        <th>{{ trans('web::seat.progress') }}</th>
        <th>{{ trans('seat-pi::common.cycle.header') }}</th>
        <th>{{ trans('seat-pi::common.cycle.quantity_header') }}</th>
        <th>{{ trans('seat-pi::common.cycle.quantity_per_hour') }}</th>
        <th>{{ trans('seat-pi::common.cycle.last_cycle_start') }}</th>
        <th>{{ trans('web::seat.expiry') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($colony->extractors as $extractor)
        <tr>
            <td>
                @include('web::partials.type', ['type_id' => $extractor->product->typeID, 'type_name' => $extractor->product->typeName])
            </td>
            <td>{{ $colony->upgrade_level }}</td>
            <td>
                <div
                        class="countdown-progressbar"
                        data-expiry-time="{{$extractor->pin->expiry_time}}"
                        data-install-time="{{ $extractor->pin->install_time }}"
                ></div>
            </td>
            <td>
                {{trans('seat-pi::common.cycle.time', ['time' => $extractor->cycle_time])}}
            </td>
            <td>
                {{$extractor->qty_per_cycle}}
            </td>
            <td>
                {{(3600 / $extractor->cycle_time) * $extractor->qty_per_cycle}}
            </td>
            <td>
                {{$extractor->pin->last_cycle_start}}
            </td>
            <td>
                <div class="countdown"
                     data-expiry-time="{{ $extractor->pin->expiry_time }}">
                    {{ $extractor->pin->expiry_time }}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
