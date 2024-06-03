<div class="card">
    <div class="card-header  d-flex align-items-center">
        <button
                type="button"
                class="btn btn-primary mr-4"
                data-toggle="modal"
                data-target="#modalAssignPlanet"
                @if(empty($unassignedPlanets))
                    disabled
                @endif
        >
            <i class="fas fa-plus"></i>
        </button>
        <h3 class="card-title">{{trans('seat-pi::project.assigned_planets.title')}}</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-condensed table-striped table-hover" id="planetTable">
            <thead>
            <tr>
                <th>{{trans_choice('web::seat.character', count($project->planets))}}</th>
                <th>{{trans('web::seat.planet')}}</th>
                <th class="text-right">{{trans('seat-pi::common.table.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($project->planets as $colony)
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
                    <td class="text-right">
                        @isset($corporation)
                            @canany(['corporation.assign_pi_planet', 'corporation.admin_pi_planet'], $colony, $corporation)
                                @include('seat-pi::includes.partials.actions.remove_btn', [
                                    'route' => route('seat-pi::unassign-corp-pi-project-planet', ['corporation' => $corporation->corporation_id, 'project' => $project->id, 'planet' => $colony->id]),
                                    'tooltip' => trans('seat-pi::project.assigned_planets.modals.unassign.tooltip'),
                                    'title' => trans('seat-pi::project.assigned_planets.modals.unassign.title'),
                                    'notice' => trans('seat-pi::project.assigned_planets.modals.unassign.notice', ['name' => $colony->planet->name, 'character' => $colony->character->name]),
                                    'icon' => 'fa-minus-square text-warning',
                                    'dataTarget' => '#modalConfirmUnassignPlanet',
                                    'cssClass' => 'pi-remove-btn'
                                ])
                            @endcan
                        @else
                            @include('seat-pi::includes.partials.actions.remove_btn', [
                                'route' => route('seat-pi::remove-assigned-planet', ['project' => $project->id, 'planet' => $colony->id]),
                                'tooltip' => trans('seat-pi::project.assigned_planets.modals.unassign.tooltip'),
                                'title' => trans('seat-pi::project.assigned_planets.modals.unassign.title'),
                                'notice' => trans('seat-pi::project.assigned_planets.modals.unassign.notice', ['name' => $colony->planet->name, 'character' => $colony->character->name]),
                                'icon' => 'fa-minus-square text-warning',
                                'dataTarget' => '#modalConfirmUnassignPlanet',
                                'cssClass' => 'pi-remove-btn'
                            ])
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('seat-pi::includes.modals.confirm_unassign')
@isset($corporation)
    @include('seat-pi::includes.modals.assign_planet', [
        'route' => route('seat-pi::assign-corp-pi-project-planet', ['corporation' => $corporation->corporation_id, 'project' => $project->id])
    ])
@else
    @include('seat-pi::includes.modals.assign_planet', [
        'route' => route('seat-pi::assign-planet-to-project', ['project' => $project->id])
    ])
@endisset

@push('javascript')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#planetTable').DataTable({
                searching: false,
                paging: true,
                pageLength: 10
            });
        });
    </script>
@endpush