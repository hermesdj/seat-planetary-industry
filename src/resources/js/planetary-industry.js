$(document).ready(function () {
    const modalDelete = $('#modalConfirmRemoveObject');

    $('button.pi-remove-btn').on('click', function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        const route = $(this).attr('data-route');
        const title = $(this).attr('data-modal-title');
        const notice = $(this).attr('data-modal-notice');

        if (route) {
            $('#formDelete').attr('action', route);

            if (title) {
                $('#removeModalTitle').text(title);
            }
            if (notice) {
                $('#removeModalNotice').text(notice);
            }

            modalDelete.modal('show');
        }
    });

    const modalEditObjective = $('#modalEditObjective');

    $('button.pi-edit-objective-btn').on('click', function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        const route = $(this).attr('data-route');
        const targetQuantity = $(this).attr('data-target-quantity');
        const schematicId = $(this).attr('data-schematic-id');

        if (route) {
            $('#formEditObjective').attr('action', route);
            $('#edit_current_quantity').val(targetQuantity);
            $('#edit_schematic_id').val(schematicId);

            modalEditObjective.modal('show');
        }
    });
});