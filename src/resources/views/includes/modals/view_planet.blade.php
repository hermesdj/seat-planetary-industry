<div class="modal fade" tabindex="-1" role="dialog" id="{{$modalId}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    @include('web::partials.type', ['type_id' => $colony->planet->type->typeID, 'type_name' => ucwords($colony->planet->name)])
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                @include('seat-pi::includes.partials.extractors', ['colony' => $colony])
                @include('seat-pi::includes.partials.factories', ['factories' => $colony->factories])
                @include('seat-pi::includes.partials.planet_content', ['colony' => $colony])
            </div>
        </div>
    </div>
</div>