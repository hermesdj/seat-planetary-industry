<div class="col-md-12">
    @include('seat-pi::includes.project.fabrication')
</div>
<div class="col-md-12">
    @include('seat-pi::includes.project.extraction')
</div>
@foreach($projects as $project)
    @foreach($project->planets as $colony)
        @include('seat-pi::includes.modals.view_planet', ['planet' => $colony, 'modalId' => 'modalViewAssignedPlanet-' . $colony->id])
    @endforeach
@endforeach