<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::project.fabrication.title')}}</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-condensed table-striped table-hover" id="fabricationTable">
            <thead>
            <tr>
                <th>{{trans('seat-pi::project.fabrication.columns.schematic')}}</th>
                <th>{{trans('seat-pi::project.fabrication.columns.tier')}}</th>
                <th class="text-center">{{trans('seat-pi::project.fabrication.columns.factoriesNeeded')}}</th>
                <th class="text-center">{{trans('seat-pi::project.fabrication.columns.actualFactories')}}</th>
                <th class="text-center">{{trans('seat-pi::project.fabrication.columns.deltaFactories')}}</th>
                <th class="text-center">{{trans('seat-pi::project.fabrication.columns.productionNeeded')}}</th>
                <th class="text-center">{{trans('seat-pi::project.fabrication.columns.actualProduction')}}</th>
                <th class="text-right">{{trans('seat-pi::project.fabrication.columns.deltaProduction')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($overview->fabrications as $fabrication)
                <tr>
                    <td>
                        @if($fabrication->colonies->isEmpty())
                            @include('web::partials.type', ['type_id' => $fabrication->schematic->invtype->typeID, 'type_name' => ucwords($fabrication->schematic->schematic_name)])
                        @else
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                   aria-expanded="false">
                                    @include('web::partials.type', ['type_id' => $fabrication->schematic->invtype->typeID, 'type_name' => ucwords($fabrication->schematic->schematic_name)])
                                </a>
                                <div class="dropdown-menu">
                                    <div>
                                        @include('seat-pi::includes.modals.view_colonies', ['resource' => $fabrication->schematic->invtype, 'colonies' => $fabrication->colonies])
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="text-center">{{$fabrication->tier->tier_id}}</td>
                    <td class="text-center">{{$fabrication->factoriesNeeded}}</td>
                    <td class="text-center">{{$fabrication->actualFactories}}</td>
                    <td class="text-center">
                        @include('seat-pi::includes.partials.delta', ['delta' => $fabrication->actualFactories - $fabrication->factoriesNeeded])
                    </td>
                    <td class="text-center">{{$fabrication->productionNeeded}}</td>
                    <td class="text-center">{{$fabrication->actualProduction}}</td>
                    <td class="text-right">
                        @include('seat-pi::includes.partials.delta', ['delta' => $fabrication->actualProduction - $fabrication->productionNeeded])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#fabricationTable').DataTable({
                searching: false,
                paging: false,
                order: [1, 'desc']
            });
        });
    </script>
@endpush