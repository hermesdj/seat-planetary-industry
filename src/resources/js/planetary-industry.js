$(document).ready(function () {
    $('button.pi-remove-btn').on('click', function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        const route = $(this).attr('data-route');
        const title = $(this).attr('data-modal-title');
        const notice = $(this).attr('data-modal-notice');
        const target = $(this).attr('data-target');

        if (route) {
            $('#formUnassign').attr('action', route);

            if (title) {
                $('#unassignModalTitle').text(title);
            }
            if (notice) {
                $('#unassignModalNotice').text(notice);
            }

            $(target).modal('show');
        } else {
            console.warn('No route found !');
        }
    });

    $('button.pi-edit-objective-btn').on('click', function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        const route = $(this).attr('data-route');
        const targetQuantity = $(this).attr('data-target-quantity');
        const schematicId = $(this).attr('data-schematic-id');
        const target = $(this).attr('data-target');
        console.log(target);

        if (route) {
            $('#formEditObjective').attr('action', route);
            $('#edit_current_quantity').val(targetQuantity);
            $('#edit_schematic_id').val(schematicId);

            $(target).modal('show');
        } else {
            console.warn('No route found !');
        }
    });
});