<div class="card">
    <div class="card-header d-flex align-items-center">
        @isset($corporation)
            @can('corporation.manage_pi_projects', $corporation)
                <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                        data-target="#modalCreateProject">
                    <i class="fas fa-plus"></i>
                </button>
            @endcan
        @else
            <button type="button" class="btn btn-primary mr-4" data-toggle="modal"
                    data-target="#modalCreateProject">
                <i class="fas fa-plus"></i>
            </button>
        @endisset
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
                    href="{{isset($corporation) ? route('seat-pi::corporation-pi-project', ['corporation' => $corporation->corporation_id, 'project' => $project->id]) : route('seat-pi::view-account-pi-project', ['project' => $project->id])}}"
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
@isset($corporation)
    @include('seat-pi::includes.modals.create_project', ['route' => route('seat-pi::create-corporation-pi-project', ['corporation' => $corporation->corporation_id])])
@else
    @include('seat-pi::includes.modals.create_project', ['route' => route('seat-pi::create-account-pi-project')])
@endif
