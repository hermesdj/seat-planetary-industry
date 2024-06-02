<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title flex-grow-1">{{$project->name}}</h3>
                <div>
                    @isset($corporation)
                        @can('corporation.manage_pi_projects', $corporation)
                            @include('seat-pi::includes.partials.actions.edit_project')
                            @include('seat-pi::includes.partials.actions.remove_btn', [
                                'route' => route('seat-pi::delete-corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]),
                                'tooltip' => trans('seat-pi::project.modals.delete.tooltip'),
                                'title' => trans('seat-pi::project.modals.delete.title'),
                                'notice' => trans('seat-pi::project.modals.delete.notice'),
                                'dataTarget' => '#modalConfirmRemoveObject'
                            ])
                        @endcan
                    @else
                        @include('seat-pi::includes.partials.actions.edit_project')
                        @include('seat-pi::includes.partials.actions.remove_btn', [
                            'route' => route('seat-pi::delete-account-pi-project', ['project' => $project->id]),
                            'tooltip' => trans('seat-pi::project.modals.delete.tooltip'),
                            'title' => trans('seat-pi::project.modals.delete.title'),
                            'notice' => trans('seat-pi::project.modals.delete.notice'),
                            'dataTarget' => '#modalConfirmRemoveObject'
                        ])
                    @endisset
                </div>
            </div>
            <div class="card-body">
                <div class="text-muted">
                    {{$project->description ?? trans('seat-pi::project.no_description')}}
                </div>
            </div>
        </div>
    </div>
    @isset($corporation)
        @include('seat-pi::includes.modals.edit_project', ['route' => route('seat-pi::edit-corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id])])
    @else
        @include('seat-pi::includes.modals.edit_project', ['route' => route('seat-pi::edit-account-pi-project', ['project' => $project->id])])
    @endisset
    <div class="col-md-6">
        @include('seat-pi::includes.project.objectives')
    </div>
    <div class="col-md-6">
        @include('seat-pi::includes.project.assigned-planets')
    </div>
    <div class="col-md-12">
        @include('seat-pi::includes.project.fabrication')
    </div>
    <div class="col-md-12">
        @include('seat-pi::includes.project.extraction')
    </div>

    @foreach($project->planets as $colony)
        @include('seat-pi::includes.modals.view_planet', ['planet' => $colony, 'modalId' => 'modalViewAssignedPlanet-' . $colony->id])
    @endforeach
</div>