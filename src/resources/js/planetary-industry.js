function execRemoveBtn(target, route, title, notice) {
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
}

function editObjective(route, targetQuantity, schematicId, target) {
    if (route) {
        $('#formEditObjective').attr('action', route);
        $('#edit_current_quantity').val(targetQuantity);
        $('#edit_schematic_id').val(schematicId);

        $(target).modal('show');
    } else {
        console.warn('No route found !');
    }
}