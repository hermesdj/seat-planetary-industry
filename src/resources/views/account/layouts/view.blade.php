@extends('web::layouts.grids.12')

@section('title', trans('seat-pi::account.page.title'))

@push('javascript')
    <script src="{{ asset('web/js/planetary-industry.js') }}"></script>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-12">
            @include('seat-pi::account.includes.menu')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @yield('seat-pi-content')
        </div>
    </div>
    @include('seat-pi::includes.modals.confirm_remove')
    @include('seat-pi::includes.modals.confirm_unassign')
@stop