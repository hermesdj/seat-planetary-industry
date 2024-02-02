<div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmRemoveObject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">
                    <i class="fas fa-trash-alt"></i>
                    <span id="removeModalTitle">{{trans('seat-pi::common.modals.remove.title')}}</span>
                </h4>
            </div>
            <div class="modal-body">
                <p id="removeModalNotice">{{trans('seat-pi::common.modals.remove.notice')}}</p>
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form id="formDelete" method="POST" action="">
                    @method('DELETE')
                    @csrf
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('web::seat.no') }}
                        </button>
                        <button type="submit" class="btn btn-danger" id="confirm_delete_submit">
                            <i class="fas fa-check-circle"></i> {{ trans('web::seat.yes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>