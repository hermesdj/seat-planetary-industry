<div class="card">
    <div class="card-header d-flex align-items-center">
        <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                data-target="#modalCreateProject">
            <i class="fas fa-plus"></i>
        </button>
        <div class="card-title">
            {{trans('seat-pi::common.menu.projects')}}
        </div>
    </div>
    <div class="list-group list-group-flush">
        @if($projects->isEmpty())
            <div class="list-group-item">
                {{trans('seat-pi::project.list.empty')}}
            </div>
        @endif
        @foreach($projects as $project)
            <a
                    href="{{route('seat-pi::view-account-pi-project', ['id' => $project->id])}}"
                    class="list-group-item list-group-item-action @if(isset($displayedProject) && $displayedProject->id === $project->id) active @endif"
            >
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        {{$project->name}}
                    </h6>
                </div>
                <p class="mb-1">
                    {{$project->description ?? trans('seat-pi::project.no_description')}}
                </p>
            </a>
        @endforeach
    </div>
</div>
@include('seat-pi::account.modals.create_project')
