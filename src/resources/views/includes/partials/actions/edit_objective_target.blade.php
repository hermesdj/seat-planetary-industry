<button
        type="button"
        data-toggle="modal"
        data-target="#modalEditObjective"
        class="btn btn-sm btn-link pi-edit-objective-btn"
        data-route="{{$route}}"
        data-target-quantity="{{$targetQuantity}}"
        data-schematic-id="{{$schematic_id}}"
>
    <i class="fas fa-edit text-info" data-toggle="tooltip" data-placement="top"
       title="{{ trans('seat-pi::project.objectives.modals.edit.tooltip') }}"></i>
</button>