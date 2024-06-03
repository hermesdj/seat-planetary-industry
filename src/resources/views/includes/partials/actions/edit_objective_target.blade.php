<button
        type="button"
        data-target="#modalEditObjective"
        class="btn btn-sm btn-link pi-edit-objective-btn"
        data-route="{{$route}}"
        data-target-quantity="{{$targetQuantity}}"
        data-schematic-id="{{$schematic_id}}"
        onclick="editObjective('{{$route}}', '{{$targetQuantity}}', '{{$schematic_id}}', '#modalEditObjective')"
>
    <i class="fas fa-edit text-info" data-toggle="tooltip" data-placement="top"
       title="{{ trans('seat-pi::project.objectives.modals.edit.tooltip') }}"></i>
</button>