@extends('seat-pi::account.layouts.view', ['viewname' => 'storage'])

@section('page_header', trans('seat-pi::account.page.header'))

@push('javascript')
    <script>
        $(document).ready(function() {
            var table = $('#storageTable').DataTable();

            function filterTable() {
                var showStorageFacility = $('#storageFacility').is(':checked');
                var showLaunchPad = $('#launchPad').is(':checked');

                var storageFacilityIds = [2541, 2536, 2257, 2558, 2535, 2560, 2561, 2562];
                var launchPadIds = [2544, 2543, 2552, 2555, 2542, 2556, 2557, 2256];

                $.fn.dataTable.ext.search = [];
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var storageType = parseInt($(table.row(dataIndex).node()).data('storage-type'));
                    if ((storageFacilityIds.includes(storageType) && showStorageFacility) ||
                    (launchPadIds.includes(storageType) && showLaunchPad)) {
                    return true;
                    }
                    return false;
                });

                table.draw();
            }

            $('#storageFacility, #launchPad').change(filterTable);

            filterTable();
        });
    </script>
@endpush

@section('seat-pi-content')
    @include('seat-pi::account.includes.storage')
@endsection
