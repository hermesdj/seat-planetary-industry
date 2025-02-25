<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::common.menu.extractors')}}</h3>
    </div>
    <div class="card-body">
        <table class="table datatable table-sm table-condensed table-striped table-hover">
            <thead>
            <tr>
                <th>{{trans_choice('web::seat.character', count($characters))}}</th>
                <th>{{trans('web::seat.planet')}}</th>
                <th>{{ trans('web::seat.upgrade_level') }}</th>
                <th>{{ trans('web::seat.product') }}</th>
                <th>{{ trans('web::seat.progress') }}</th>
                <th>{{ trans('web::seat.expiry') }}</th>
                <th>{{ trans('seat-pi::common.cycle.header') }}</th>
                <th>{{ trans('seat-pi::common.cycle.quantity_header') }}</th>
                <th>{{ trans('seat-pi::common.cycle.quantity_per_hour') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($characters as $character)
                @foreach($character->colonies as $colony)
                    @foreach($colony->extractors as $extractor)
                        <tr>
                            <td>
                                @include('web::partials.character', ['character' => $character])
                            </td>
                            <td>
                                @include('web::partials.type', ['type_id' => $colony->planet->type->typeID, 'type_name' => ucwords($colony->planet->name)])
                                &nbsp;
                                ({{ucwords($colony->planet_type)}})
                            </td>
                            <td>{{ $colony->upgrade_level }}</td>
                            <td>
                                @include('web::partials.type', ['type_id' => $extractor->product->typeID, 'type_name' => $extractor->product->typeName])
                                <a class="float-right" href="{{ route('seat-pi::account-pi-templates', [
                                    'characterId' => $character->character_id,
                                    'commandCenterLevel' => $colony->upgrade_level,
                                    'resourceTypeId' => $extractor->product->typeID,
                                    'planetId' => $colony->planet->planet_id,
                                    'planetTypeId' => $colony->planet->type->typeID,
                                    'factories' => 10]) }}"><i class="fas fa-file-code"></i></a>
                            </td>
                            <td>
                                <div class="countdown-progressbar"
                                    data-expiry-time="{{$extractor->pin->expiry_time}}"
                                    data-install-time="{{ $extractor->pin->install_time }}"
                                ></div>
                            </td>
                            <td>
                                <div class="countdown"
                                    data-expiry-time="{{ $extractor->pin->expiry_time }}">
                                    {{ $extractor->pin->expiry_time }}
                                </div>
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
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            function updateExpiryText() {
                $(".countdown").each(function () {
                    $(this).text(moment.utc($(this).attr('data-expiry-time'), "YYYY-MM-DD hh:mm:ss").calendar());
                });
            }

            function updateProgressBar() {
                $(".countdown-progressbar").each(function () {
                    let expiry_time = moment.utc($(this).attr('data-expiry-time'), "YYYY-MM-DD hh:mm:ss").valueOf();
                    let install_time = moment.utc($(this).attr('data-install-time'), "YYYY-MM-DD hh:mm:ss").valueOf();
                    let percentage_complete = (moment.utc() - install_time) / (expiry_time - install_time);
                    let percentage_rounded = (Math.round(percentage_complete * 100) / 100);
                    let progress_value = Math.round(percentage_rounded * 100);
                    let progress_class = 'progress-bar progress-bar-striped';

                    if (progress_value > 100) {
                        progress_value = 100;
                    }

                    switch (true) {
                        case (percentage_rounded < 0.4):
                            progress_class += ' progress-bar-success progress-bar-striped';
                            break;
                        case (percentage_rounded >= 0.4 && percentage_rounded < 0.6):
                            progress_class += ' progress-bar-info progress-bar-striped';
                            break;
                        case (percentage_rounded >= 0.6 && percentage_rounded < 0.8):
                            progress_class += ' progress-bar-warning progress-bar-striped';
                            break;
                        case (percentage_rounded < 1):
                            progress_class += ' progress-bar-danger progress-bar-striped';
                            break;
                        default:
                            progress_class += ' progress-bar-danger progress-bar-striped';
                    }

                    $(this).html(
                        "<div class='progress active'>" +
                        '<div class="' + progress_class + '" role="progressbar" ' +
                        'aria-valuenow="' + progress_value + '" aria-valuemin="0" aria-valuemax="100" ' +
                        'style="width: ' + progress_value + '%" >' + progress_value +
                        '%</div>' +
                        '</div>'
                    );
                });
            }

            updateExpiryText();
            updateProgressBar();
            setInterval(function () { //this is to update every 15 seconds
                updateExpiryText();
                updateProgressBar();
            }, 15000);
        });
    </script>
@endpush