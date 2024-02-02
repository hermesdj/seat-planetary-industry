<div class="modal fade" tabindex="-1" role="dialog" id="modalAddObjective">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    <i class="fas fa-space-shuttle">
                        {{trans('seat-pi::project.objectives.modals.create.title')}}
                    </i>
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form class="form-horizontal" id="formAddObjective" method="POST"
                      action="{{route('seat-pi::add-project-objective', ['id' => $project->id])}}">
                    @csrf
                    <div class="form-group row">
                        <label for="schematic_id" class="col-sm-3 col-form-label">
                            {{trans('seat-pi::project.objectives.fields.schematic.label')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select
                                    id="schematic_id"
                                    class="form-control"
                                    name="schematic_id"
                            >
                                <option disabled selected value>--</option>
                                @foreach($tiers as $tier)
                                    @if(!$tier->schematics->isEmpty())
                                        <optgroup label="Tier {{$tier->tier_id}}">
                                            @foreach($tier->schematics->sortBy('schematic_name') as $schematic)
                                                <option value="{{$schematic->schematic_id}}">{{$schematic->schematic_name}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="target_quantity" class="col-sm-3 col-form-label">
                            {{trans('seat-pi::project.objectives.fields.target_quantity.label')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select
                                    id="target_quantity"
                                    class="form-control"
                                    name="target_quantity"
                            >

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

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            const tiers = {!! json_encode($tiers) !!};
            const schematicMap = new Map();

            for (const tier of tiers) {
                if (tier.schematics && tier.schematics.length > 0) {
                    for (const schematic of tier.schematics) {
                        schematicMap.set(schematic.schematic_id, {
                            ...schematic,
                            tier
                        });
                    }
                }
            }

            const schematicSelect = $('#schematic_id');
            const targetQuantitySelect = $('#target_quantity');

            function updateTargetQuantitySelect() {
                targetQuantitySelect.val(null);
            }

            schematicSelect.on('change', function () {
                const schematicId = parseInt($(this).val());

                if (schematicMap.has(schematicId)) {
                    const schematic = schematicMap.get(schematicId);

                    targetQuantitySelect.empty();

                    for (let i = schematic.tier.quantity_produced; i <= schematic.tier.quantity_produced * 100; i += schematic.tier.quantity_produced) {
                        const value = (i / ((schematic.cycle_time) / 3600));
                        targetQuantitySelect.append($('<option></option>').attr('value', value).text(value + '/h'));
                    }
                } else {
                    console.warn('Unknown schematic id selected', schematicId);
                }
            });
        });
    </script>
@endpush
