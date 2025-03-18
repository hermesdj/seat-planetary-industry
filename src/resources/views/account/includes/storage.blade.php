<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::common.menu.storage')}}</h3>
        <div class="float-right">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="storageFacility" value="storage-facility" checked>
                <label class="form-check-label" for="storageFacility">Storage Facility</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="launchPad" value="launch-pad" checked>
                <label class="form-check-label" for="launchPad">Launch Pad</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="warningMessage" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
            {!! trans('seat-pi::common.storage.messages.warning') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="{{ trans('seat-pi::common.btns.close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <table class="table datatable table-sm table-condensed table-striped table-hover" id="storageTable">
            <thead>
            <tr>
                <th>{{ trans_choice('web::seat.character', 2) }}</th>
                <th>{{ trans('web::seat.planet') }}</th>
                <th>{{ trans('seat-pi::common.storage.headers.storage') }}</th>
                <th>{{ trans('seat-pi::common.storage.headers.capacity') }}</th>
                <th>{{ trans('seat-pi::common.storage.headers.used_capacity') }}</th>
                <th>{{ trans('seat-pi::common.storage.headers.progress') }}</th>
                <th>{{ trans('seat-pi::common.storage.headers.contents') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($containers as $container)
                <tr data-storage-type="{{ $container->type_id }}">
                    <td>
                        @include('web::partials.character', ['character' => $container->character])
                    </td>
                    <td>
                        @if($container->colony)
                            @include('web::partials.type', [
                                'type_id' => $container->colony->planet->type->typeID,
                                'type_name' => ucwords($container->colony->planet->name)
                            ])
                            &nbsp;
                            ({{ucwords($container->colony->planet_type)}})
                        @endif
                    </td>
                    <td>
                        @include('web::partials.type', [
                            'type_id' => $container->type_id,
                            'type_name' => $container->type->typeName
                        ])
                    </td>
                    <td data-order="{{ $container->type->capacity }}">
                        {{ number_format($container->type->capacity) }} m<sup>3</sup>
                    </td>
                    @php
                        $totalVolume = 0;
                    @endphp
                    @foreach($container->contents as $content)
                        @php
                            $totalVolume += $content->type->volume * $content->amount;
                        @endphp
                    @endforeach
                    <td data-order="{{ $totalVolume }}">
                        {{ number_format($totalVolume, 2) }} m<sup>3</sup>
                    </td>
                    <td>
                        <div class="progress">
                            @php
                                $percentage = ($totalVolume / $container->type->capacity) * 100;
                                $progressBarClass = 'bg-success';
                                if ($percentage > 90) {
                                    $progressBarClass = 'bg-danger';
                                } elseif ($percentage > 70) {
                                    $progressBarClass = 'bg-warning';
                                }
                            @endphp
                            <div class="progress-bar {{ $progressBarClass }} progress-bar-striped" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $totalVolume }}" aria-valuemin="0" aria-valuemax="{{ $container->type->capacity }}">
                                {{ number_format($percentage, 2) }}%
                            </div>
                        </div>
                    </td>
                    <td>
                    @php
                        $contents = $container->contents->sortBy(function($content) {
                            return $content->type->pi_tier->tier . $content->type->typeName;
                        });
                    @endphp
                    @foreach($contents as $content)
                        @include('web::partials.type', [
                            'type_id' => $content->type_id,
                            'type_name' => $content->type->typeName
                        ])
                        <small>(P{{ $content->type->pi_tier->tier_id }})</small>
                    @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
