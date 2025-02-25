<div class="row">
    <div class="col col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('seat-pi::templates.headers.configurator') }}</h3>
            </div>
            <div class="card-body">
                <form id="configuratorForm">
                    <div class="form-group">
                        <label for="character">{{ trans_choice('web::seat.character', 1) }}</label>
                        <select class="form-control" id="character" name="character">
                            @foreach ($characters as $character)
                                <option data-skill-level="{{ $character->skills()->where('skill_id', 2505)->first()->trained_skill_level ?? 0 }}"
                                    value="{{ $character->character_id }}"
                                    {{ request()->get('characterId') == $character->character_id ? 'selected' : '' }}>{{ $character->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl-6">
                            <label for="productType">{{ trans('seat-pi::templates.configurator.product') }}</label>
                            <select class="form-control" id="productType" name="productType">
                                @foreach ($productTypes as $productType)
                                    <option data-product-id="{{ $productType->typeID }}"
                                        data-resource-id="{{ $productMapping[$productType->typeID]['resource'] }}"
                                        value="{{ $productType->typeID }}"
                                        {{ request()->get('productTypeId') == $productType->typeID ||
                                        request()->get('resourceTypeId') == $productMapping[$productType->typeID]['resource']
                                            ? 'selected'
                                            : '' }}>{{ $productType->typeName }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="productTypeHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group col-xl-6">
                            <label for="planetType">{{ trans('seat-pi::templates.configurator.planet_type') }}</label>
                            <select class="form-control" id="planetType" name="planetType"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl-6">
                            <label
                                for="commandCenterLevel">{{ trans('seat-pi::templates.configurator.command_center') }}</label>
                            <select class="form-control" id="commandCenterLevel" name="commandCenterLevel">
                                @for ($i = 0; $i <= 5; $i++)
                                    <option data-cpu-provided="{{ $commandCenters[$i]->cpuProvided }}"
                                        data-power-provided="{{ $commandCenters[$i]->powerProvided }}"
                                        value="{{ $i }}"
                                        {{ request()->get('commandCenterLevel') == $i ? 'selected' : '' }}>Level
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            <small id="commandCenterLevelHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group col-xl-6">
                            <label for="factories">{{ trans('seat-pi::templates.configurator.factories') }}</label>
                            <select class="form-control" id="factories" name="factories">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option
                                        data-cpu-required="{{ collect($structures)->firstWhere('name', 'Basic Industry Facility')->cpuRequired }}"
                                        data-power-required="{{ collect($structures)->firstWhere('name', 'Basic Industry Facility')->powerRequired }}"
                                        value="{{ $i }}"
                                        {{ request()->get('factories') == $i || (request()->get('factories') === null && $i == 10) ? 'selected' : '' }}>
                                        {{ $i == 10 ? $i . ' (Recommended)' : $i }}
                                    </option>
                                @endfor
                            </select>
                            <small id="factoriesHelp" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div>
                        <label for="commandCenterLevel">{{ trans('seat-pi::templates.configurator.options') }}</label>
                    </div>
                    @php
                        $launchpad = collect($structures)->firstWhere('name', 'Launchpad');
                        $storageFacility = collect($structures)->firstWhere('name', 'Storage Facility');
                        $extractorControlUnit = collect($structures)->firstWhere('name', 'Extractor Control Unit');
                        $extractorHead = collect($structures)->firstWhere('name', 'Extractor Head');
                    @endphp
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="launchPad" name="Launchpad" checked
                            disabled>
                        <label class="form-check-label" for="launchPad">Launchpad</label>
                        <small class="form-text text-muted">
                            {{ trans('seat-pi::templates.configurator.required') }}: {{ $launchpad->powerRequired }}
                            MW / {{ $launchpad->cpuRequired }} TF
                        </small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="storageFacility" name="Storage Facility"
                            checked disabled>
                        <label class="form-check-label" for="storageFacility">Storage Facility</label>
                        <small class="form-text text-muted">
                            {{ trans('seat-pi::templates.configurator.required') }}:
                            {{ $storageFacility->powerRequired }} MW / {{ $storageFacility->cpuRequired }}
                            TF
                        </small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="extractor" name="extractor"
                            {{ request()->get('extractor') == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="extractor">Extractor Control Unit</label>
                        <small class="form-text text-muted">
                            {{ trans('seat-pi::templates.configurator.required') }}:
                            {{ $extractorControlUnit->powerRequired }} MW /
                            {{ $extractorControlUnit->cpuRequired }} TF (Extractor Head 10x:
                            {{ $extractorHead->powerRequired * 10 }} MW / {{ $extractorHead->cpuRequired * 10 }} TF)
                        </small>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('seat-pi::templates.configurator.consumption') }}</label>
                        <div class="row">
                            <div class="col" id="buildCost"></div>
                        </div>
                        <div class="row">
                            <div class="col" id="availablePowerCpu"></div>
                        </div>
                        <div class="row">
                            <div class="col" id="usedPowerCpu"></div>
                        </div>
                    </div>
                    <div class="alert alert-warning d-none" role="alert" id="extractorWarning">
                        <i class="fa fa-exclamation-triangle"></i>
                        {{ trans('seat-pi::templates.alerts.extractor') }}
                    </div>
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle"></i>
                        {!! trans('seat-pi::templates.alerts.compressPins') !!}
                    </div>
                    <button type="button" class="btn btn-primary" id="copyButton">
                        <i class="fas fa-copy"></i>
                        {{ trans('seat-pi::templates.buttons.copy') }}
                    </button>
                    <button type="button" class="btn btn-secondary" id="downloadButton">
                        <i class="fas fa-download"></i>
                        {{ trans('seat-pi::templates.buttons.download') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('seat-pi::templates.headers.available_planets') }}</h3>
            </div>
            <div class="card-body">
                <table class="table datatable table-sm table-condensed table-striped table-hover"
                    id="planetOverviewTable">
                    <thead>
                        <tr>
                            <th>{{ trans_choice('web::seat.character', 2) }}</th>
                            <th>{{ trans('web::seat.planet') }}</th>
                            <th>{{ trans_choice('web::seat.type', 1) }}</th>
                            <th>{{ trans('web::seat.upgrade_level') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planetOverview as $colony)
                            <tr data-character-id="{{ $colony->character->character_id }}"
                                data-planet-id="{{ $colony->planet->planet_id }}"
                                data-planet-type-id="{{ $colony->planet->type->typeID }}">
                                <td>
                                    @include('web::partials.character', [
                                        'character' => $colony->character,
                                    ])
                                </td>
                                <td>
                                    @include('web::partials.type', [
                                        'type_id' => $colony->planet->type->typeID,
                                        'type_name' => ucwords($colony->planet->name),
                                    ])
                                </td>
                                <td>
                                    {{ ucwords($colony->planet_type) }}
                                </td>
                                <td>
                                    {{ $colony->upgrade_level }}/{{ $colony->character->skills()->where('skill_id', 2505)->first()->trained_skill_level ?? 0 }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
