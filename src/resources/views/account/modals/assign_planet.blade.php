<div class="modal fade" tabindex="-1" role="dialog" id="modalAssignPlanet">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    <i class="fas fa-space-shuttle">
                        {{trans('seat-pi::project.assigned_planets.modals.assign.title')}}
                    </i>
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form class="form-horizontal" id="formAssignPlanet" method="POST"
                      action="{{route('seat-pi::assign-planet-to-project', ['id' => $project->id])}}">
                    @csrf
                    <div class="form-group row">
                        <label for="character_planet_id" class="col-sm-3 col-form-label">
                            {{trans('seat-pi::project.assigned_planets.fields.planet.label')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select
                                    id="character_planet_id"
                                    class="form-control"
                                    name="character_planet_id"
                            >
                                <option disabled selected value>--</option>
                                @foreach($unassignedPlanets as $character => $colonies)
                                    @if(!$colonies->isEmpty())
                                        <optgroup label="{{$character}}">
                                            @foreach($colonies as $colony)
                                                <option value="{{$colony->id}}">{{ucwords($colony->planet->name)}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('seat-pi::common.btns.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-success" id="add_objective_submit">
                            <i class="fas fa-check-circle"></i> {{ trans('seat-pi::common.btns.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
