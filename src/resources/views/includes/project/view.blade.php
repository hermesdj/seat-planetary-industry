<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title flex-grow-1">{{$project->name}}</h3>
                <div>
                    @include('seat-pi::includes.partials.actions.edit_project')
                    @include('seat-pi::includes.partials.actions.remove_btn', [
                        'route' => route('seat-pi::delete-account-pi-project', ['id' => $project->id]),
                        'tooltip' => trans('seat-pi::project.modals.delete.tooltip'),
                        'title' => trans('seat-pi::project.modals.delete.title'),
                        'notice' => trans('seat-pi::project.modals.delete.notice'),
                    ])
                </div>
            </div>
            <div class="card-body">
                <div class="text-muted">
                    {{$project->description ?? trans('seat-pi::project.no_description')}}
                </div>
            </div>
        </div>
    </div>
    @include('seat-pi::account.modals.edit_project')
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
</div>