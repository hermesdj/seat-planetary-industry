<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('seat-pi::project.extraction.title')}}</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-condensed table-striped table-hover" id="extractionTable">
            <thead>
            <tr>
                <th>{{trans('seat-pi::project.extraction.columns.resource')}}</th>
                <th class="text-center">{{trans('seat-pi::project.extraction.columns.extractionNeeded')}}</th>
                <th class="text-center">{{trans('seat-pi::project.extraction.columns.actualExtraction')}}</th>
                <th class="text-right">{{trans('seat-pi::project.extraction.columns.deltaExtraction')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($overview->extractions as $extraction)
                <tr>
                    <td>
                        @include('web::partials.type', ['type_id' => $extraction->resource->typeID, 'type_name' => ucwords($extraction->resource->typeName)])
                    </td>
                    <td class="text-center">{{$extraction->extractionNeeded}}</td>
                    <td class="text-center">{{$extraction->actualExtraction}}</td>
                    <td class="text-right">
                        @include('seat-pi::includes.partials.delta', ['delta' => $extraction->actualExtraction - $extraction->extractionNeeded])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#extractionTable').DataTable({
                searching: false,
                paging: false,
                order: [1, 'desc']
            });
        });
    </script>
@endpush