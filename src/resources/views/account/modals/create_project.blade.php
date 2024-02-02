<div class="modal fade" tabindex="-1" role="dialog" id="modalCreateProject">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    <i class="fas fa-space-shuttle">
                        {{trans('seat-pi::account.modals.create.title')}}
                    </i>
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form class="form-horizontal" id="formCreateProject" method="POST"
                      action="{{route('seat-pi::create-account-pi-project')}}">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">
                            {{trans('seat-pi::project.fields.name.label')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" id="name" class="form-control" name="name"
                                   placeholder="{{trans('seat-pi::project.fields.name.placeholder')}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">
                            {{trans('seat-pi::project.fields.description.label')}}
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" id="description" rows="10"></textarea>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('seat-pi::common.btns.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-success" id="create_project_submit">
                            <i class="fas fa-check-circle"></i> {{ trans('seat-pi::common.btns.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>