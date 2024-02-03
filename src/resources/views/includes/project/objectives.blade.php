<div class="card">
    <div class="card-header d-flex align-items-center">
        @isset($corporation)
            @can('corporation.manage_pi_objectives', $corporation)
                <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                        data-target="#modalAddObjective">
                    <i class="fas fa-plus"></i>
                </button>
            @endcan
        @else
            <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                    data-target="#modalAddObjective">
                <i class="fas fa-plus"></i>
            </button>
        @endisset
        <h3 class="card-title">{{trans('seat-pi::project.objectives.title')}}</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-condensed table-striped table-hover" id="objectivesTable">
            <thead>
            <tr>
                <th>{{trans('seat-pi::project.objectives.fields.schematic.label')}}</th>
                <th>{{trans('seat-pi::project.objectives.fields.target_quantity.label')}}</th>
                <th class="text-right">{{trans('seat-pi::common.table.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($project->objectives as $objective)
                <tr>
                    <td>
                        @include('web::partials.type', ['type_id' => $objective->schematic->invtype->typeID, 'type_name' => ucwords($objective->schematic->schematic_name)])
                        {{$objective->schematic->schematic_name}}
                    </td>
                    <td>{{$objective->target_quantity}}</td>
                    <td class="text-right">
                        @isset($corporation)
                            @can('corporation.manage_pi_objectives', $corporation)
                                @include('seat-pi::includes.partials.actions.edit_objective_target', [
                                    'route' => route('seat-pi::edit-corp-pi-project-objective', ['corporation' => $corporation->corporation_id, 'project' => $project->id, 'schematic_id' => $objective->schematic_id]),
                                    'targetQuantity' => $objective->target_quantity,
                                    'schematic_id' => $objective->schematic_id
                                ])
                                @include('seat-pi::includes.partials.actions.remove_btn', [
                                    'route' => route('seat-pi::remove-corp-pi-project-objective', ['corporation' => $corporation->corporation_id, 'project' => $project->id, 'schematic_id' => $objective->schematic_id]),
                                    'tooltip' => trans('seat-pi::project.objectives.modals.delete.btn')
                                ])
                            @endcan
                        @else
                            @include('seat-pi::includes.partials.actions.edit_objective_target', [
                                'route' => route('seat-pi::edit-project-objective', ['project' => $project->id, 'schematic_id' => $objective->schematic_id]),
                                'targetQuantity' => $objective->target_quantity,
                                'schematic_id' => $objective->schematic_id
                            ])
                            @include('seat-pi::includes.partials.actions.remove_btn', [
                                'route' => route('seat-pi::remove-project-objective', ['project' => $project->id, 'schematic_id' => $objective->schematic_id]),
                                'tooltip' => trans('seat-pi::project.objectives.modals.delete.btn')
                            ])
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@isset($corporation)
    @include('seat-pi::includes.modals.add_objective', ['route' => route('seat-pi::add-corp-pi-project-objective', ['corporation' => $corporation->corporation_id, 'project' => $project->id])])
@else
    @include('seat-pi::includes.modals.add_objective', ['route' => route('seat-pi::add-project-objective', ['project' => $project->id])])
@endisset
@include('seat-pi::includes.modals.edit_objective');

@push('javascript')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#objectivesTable').DataTable({
                searching: false,
                paging: true,
                pageLength: 10
            });
        });
    </script>
@endpush